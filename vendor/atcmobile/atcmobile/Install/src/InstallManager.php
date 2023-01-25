<?php

namespace Atcmobapp\Install;

use Cake\Cache\Cache;
use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Database\Exception\MissingConnectionException;
use Cake\Datasource\ConnectionManager;
use Cake\Log\LogTrait;
use Cake\Utility\Security;
use Cake\ORM\TableRegistry;
use Atcmobapp\Acl\AclGenerator;
use Atcmobapp\Core\Database\SequenceFixer;
use Atcmobapp\Core\PluginManager;
use Exception;

class InstallManager
{
    const PHP_VERSION = '7.1.30';
    const CAKE_VERSION = '3.8.0';

    use LogTrait;

    /**
     * Default configuration
     *
     * @var array
     * @access public
     */
    public $defaultConfig = [
        'name' => 'default',
        'className' => 'Cake\Database\Connection',
        'driver' => 'Cake\Database\Driver\Mysql',
        'persistent' => false,
        'host' => 'localhost',
        'username' => 'root',
        'password' => '',
        'database' => 'atcmobile',
        'port' => null,
        'schema' => null,
        'prefix' => null,
        'encoding' => 'utf8',
        'timezone' => 'UTC',
        'cacheMetadata' => true,
        'log' => false,
        'quoteIdentifiers' => false,
    ];

    /**
     *
     * @var \Atcmobapp\Core\PluginManager
     */
    protected $_atcmobilePlugin;

    public function __construct()
    {
        Configure::write('Trackable.Auth.User.id', 1);
    }

    public static function versionCheck()
    {
        return [
            'php' => version_compare(phpversion(), static::PHP_VERSION, '>='),
            'cake' => version_compare(Configure::version(), static::CAKE_VERSION, '>='),
        ];
    }

    /**
     * Set the security.salt value in application config file
     *
     * @return string Success or error message
     */
    public function replaceSalt()
    {
        $file = ROOT . '/config/app.php';
        $content = file_get_contents($file);
        $newKey = hash('sha256', Security::randomBytes(64));

        $content = str_replace('__SALT__', $newKey, $content, $count);

        if ($count == 0) {
            return 'No Security.salt placeholder to replace.';
        }

        $result = file_put_contents($file, $content);
        if ($result) {
            return 'Updated Security.salt value in config/' . $file;
        }

        return 'Unable to update Security.salt value.';
    }

    public function createDatabaseFile($config)
    {
        $config += $this->defaultConfig;

        if ($config['driver'] === 'Cake\Database\Driver\Postgres') {
            if (empty($config['port'])) {
                $config['port'] = 5432;
            }
        }

        ConnectionManager::drop('default');
        ConnectionManager::setConfig('default', $config);

        try {
            /** @var \Cake\Database\Connection */
            $db = ConnectionManager::get('default');
            $db->connect();
        } catch (MissingConnectionException $e) {
            ConnectionManager::drop('default');

            return __d('atcmobile', 'Could not connect to database: ') . $e->getMessage();
        }
        if (!$db->isConnected()) {
            ConnectionManager::drop('default');

            return __d('atcmobile', 'Could not connect to database.');
        }

        $configPath = ROOT . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'app.php';
        DatasourceConfigUpdater::update($configPath, $config);

        return true;
    }

    /**
     * Mark installation as complete
     *
     * @return bool true when successful
     */
    public function installCompleted()
    {
        PluginManager::load('Atcmobapp/Settings', ['routes' => true]);
        $Setting = TableRegistry::get('Atcmobapp/Settings.Settings');
        $Setting->removeBehavior('Cached');
        if (!function_exists('mcrypt_decrypt') && !function_exists('openssl_decrypt')) {
            $Setting->write('Access Control.autoLoginDuration', '');
        }

        $Setting->updateVersionInfo();
        $Setting->updateAppVersionInfo();

        return $Setting->write('Atcmobapp.installed', true);
    }

    /**
     * Run Migrations and add data in table
     *
     * @return bool True if migrations have succeeded
     */
    public function setupDatabase()
    {
        $plugins = [
            'Atcmobapp/Users',
            'Atcmobapp/Acl',
            'Atcmobapp/Settings',
            'Atcmobapp/Blocks',
            'Atcmobapp/Taxonomy',
            'Atcmobapp/FileManager',
            'Atcmobapp/Meta',
            'Atcmobapp/Mobapps',
            'Atcmobapp/Nodes',
            'Atcmobapp/Comments',
            'Atcmobapp/Contacts',
            'Atcmobapp/Menus',
            'Atcmobapp/Dashboards',
        ];

        $migrationsSucceed = true;
        foreach ($plugins as $plugin) {
            $migrationsSucceed = $this->runMigrations($plugin);
            if (!$migrationsSucceed) {
                $this->log('Migrations failed for ' . $plugin, LOG_CRIT);
                break;
            }
        }

        foreach ($plugins as $plugin) {
            $migrationsSucceed = $this->seedTables($plugin);
            if (!$migrationsSucceed) {
                break;
            }
        }

        if ($migrationsSucceed) {
            $fixer = new SequenceFixer();
            $fixer->fix('default');
        }

        return $migrationsSucceed;
    }

    protected function _getAtcmobappPlugin()
    {
        if (!($this->_atcmobilePlugin instanceof PluginManager)) {
            $this->_setAtcmobappPlugin(new PluginManager());
        }

        return $this->_atcmobilePlugin;
    }

    protected function _setAtcmobappPlugin($atcmobilePlugin)
    {
        unset($this->_atcmobilePlugin);
        $this->_atcmobilePlugin = $atcmobilePlugin;
    }

    public function runMigrations($plugin)
    {
        if (!Plugin::isLoaded($plugin)) {
            PluginManager::load($plugin);
        }
        $atcmobilePlugin = $this->_getAtcmobappPlugin();
        $result = $atcmobilePlugin->migrate($plugin);
        if (!$result) {
            $this->log($atcmobilePlugin->migrationErrors);
        }

        return $result;
    }

    public function seedTables($plugin)
    {
        if (!Plugin::isLoaded($plugin)) {
            PluginManager::load($plugin);
        }
        $atcmobilePlugin = $this->_getAtcmobappPlugin();

        return $atcmobilePlugin->seed($plugin);
    }

    public function setupAcos()
    {
        Cache::clearAll();
        $generator = new AclGenerator();
        if ($this->controller) {
            $dummyShell = new DummyShell();
            $generator->setShell($dummyShell);
        }
        $generator->insertAcos(ConnectionManager::get('default'));
    }

    public function setupGrants($success = null, $error = null)
    {
        if (!$success) {
            $success = function () {
            };
        }
        if (!$error) {
            $error = function () {
            };
        }

        $Roles = TableRegistry::get('Atcmobapp/Users.Roles');
        $Roles->addBehavior('Atcmobapp/Core.Aliasable');

        $Permission = TableRegistry::get('Atcmobapp/Acl.Permissions');
        $admin = 'Role-admin';
        $public = 'Role-public';
        $registered = 'Role-registered';
        $publisher = 'Role-publisher';

        $setup = [
            'controllers/Atcmobapp\Contacts/Contacts/view' => [$public],
            'controllers/Atcmobapp\Nodes/Nodes/index' => [$public],
            'controllers/Atcmobapp\Nodes/Nodes/feed' => [$public],
            'controllers/Atcmobapp\Nodes/Nodes/term' => [$public],
            'controllers/Atcmobapp\Nodes/Nodes/promoted' => [$public],
            'controllers/Atcmobapp\Nodes/Nodes/search' => [$public],
            'controllers/Atcmobapp\Nodes/Nodes/view' => [$public],
            'controllers/Atcmobapp\Users/Users/index' => [$registered],
            'controllers/Atcmobapp\Users/Users/add' => [$public],
            'controllers/Atcmobapp\Users/Users/activate' => [$public],
            'controllers/Atcmobapp\Users/Users/edit' => [$registered],
            'controllers/Atcmobapp\Users/Users/forgot' => [$public],
            'controllers/Atcmobapp\Users/Users/reset' => [$public],
            'controllers/Atcmobapp\Users/Users/login' => [$public],
            'controllers/Atcmobapp\Users/Users/logout' => [$public, $registered],
            'controllers/Atcmobapp\Users/Admin/Users/logout' => [$public, $registered],
            'controllers/Atcmobapp\Users/Users/view' => [$registered],
            'controllers/Atcmobapp\Dashboards/Admin/Dashboards' => [$admin],
            'controllers/Atcmobapp\Nodes/Admin/Nodes' => [$publisher],
            'controllers/Atcmobapp\Menus/Admin/Menus' => [$publisher],
            'controllers/Atcmobapp\Menus/Admin/Links' => [$publisher],
            'controllers/Atcmobapp\Blocks/Admin/Blocks' => [$publisher],
            'controllers/Atcmobapp\FileManager/Admin/Attachments' => [$publisher],
            'controllers/Atcmobapp\FileManager/Admin/FileManager' => [$publisher],
            'controllers/Atcmobapp\Contacts/Admin/Contacts' => [$publisher],
            'controllers/Atcmobapp\Contacts/Admin/Messages' => [$publisher],
            'controllers/Atcmobapp\Users/Admin/Users/view' => [$admin],
        ];

        foreach ($setup as $aco => $roles) {
            foreach ($roles as $aro) {
                try {
                    $result = $Permission->allow($aro, $aco);
                    if ($result) {
                        $success(__d('atcmobile', 'Permission %s granted to %s', $aco, $aro));
                    }
                } catch (Exception $e) {
                    $error($e->getMessage());
                }
            }
        }
    }
}

class DummyShell extends Shell
{
    use LogTrait;
    public function out($msg = null, $newlines = 1, $level = Shell::NORMAL)
    {
        $msg = preg_replace('/\<\/?\w+\>/', null, $msg);
        $this->log($msg);
    }
}
