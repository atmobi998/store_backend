<?php

namespace Atcmobapp\Core\Shell;

use Cake\Console\ConsoleIo;
use Cake\Console\Exception\ConsoleException;
use Cake\Core\Exception\Exception;
use Cake\ORM\Locator\LocatorInterface;
use Cake\Utility\Inflector;
use Atcmobapp\Core\PluginManager;
use Atcmobapp\Core\Shell\AtcmobappAppShell;
use Atcmobapp\Extensions\AtcmobappTheme;
use Atcmobapp\Extensions\ExtensionsInstaller;

/**
 * Install Shell
 *
 * Usage:
 *  ./Console/atcmobile install plugin https://github.com/shama/myplugin/zipball/master
 *  ./Console/atcmobile install plugin shama myplugin
 *
 * @category Shell
 * @package  Atcmobapp.Atcmobapp.Console.Command
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class InstallShell extends AppShell
{

    /**
     * Tmp path to download extensions to
     *
     * @var string
     */
    public $tmpPath = TMP;

    /**
     * ExtensionsInstaller
     *
     * @var ExtensionsInstaller
     */
    protected $_ExtensionsInstaller = null;

    /**
     * AtcmobappPlugin class
     *
     * @var AtcmobappPlugin
     */
    protected $_AtcmobappPlugin = null;

    /**
     * AtcmobappTheme class
     *
     * @var AtcmobappTheme
     */
    protected $_AtcmobappTheme = null;

    /**
     * Init ExtensionsInstaller, AtcmobappPlugin, AtcmobappTheme
     *
     * @param ConsoleIo $io
     * @param LocatorInterface $locator
     */
    public function __construct(ConsoleIo $io = null, LocatorInterface $locator = null)
    {
        parent::__construct($io, $locator);
        $this->_ExtensionsInstaller = new ExtensionsInstaller();
        $this->_AtcmobappPlugin = new PluginManager();
        $this->_AtcmobappTheme = new AtcmobappTheme();
    }

    /**
     * 1. Detects URL or github user/repo or composer package
     * 2. Downloads
     * 3. Installs extension
     * 4. Activates extension
     *
     * Composer: ./Console/cake install plugin vendor/package
     * Github: ./Console/cake install plugin user repo
     * Url: ./Console/cake install plugin https://github.com/user/repo
     */
    public function main()
    {
        $type = $this->args[0];
        if (strpos($this->args[1], '/') !== false && preg_match('/http[s]*:\/\//i', $this->args[1]) === 0) {
            // Composer Install
            $ver = isset($this->args[2]) ? $this->args[2] : '*';
            $this->out(__d('atcmobile', 'Installing with Composer...'));
            try {
                $result = $this->_ExtensionsInstaller->composerInstall([
                    'package' => $this->args[1],
                    'version' => $ver,
                    'type' => $type,
                ]);
                if (!is_array($result)) {
                    $this->err(__d('atcmobile', 'Unexpected composerInstall return value'));

                    return false;
                }
                if ($result['returnValue'] <> 0) {
                    $this->err($result['output']);

                    return false;
                }
                $ext = substr($this->args[1], strpos($this->args[1], '/') + 1);
                $ext = Inflector::camelize($ext);
                $shouldActivate = $this->{'_Atcmobapp' . ucfirst($type)}->getData($ext);
                if ($shouldActivate !== false) {
                    $result = $this->dispatchShell('ext', 'activate', $type, $ext, '--quiet');
                    if ($result) {
                        $this->out(__d('atcmobile', 'Package installed and activated.'));
                    } else {
                        $this->err(__d('atcmobile', 'Package installed but not activated.'));
                    }
                }
            } catch (Exception $e) {
                $this->err($e->getMessage());
            }
        } else {
            // Github / URL Install
            $url = '';
            if (count($this->args) == 2) {
                $url = $this->args[1];
            } elseif (count($this->args) == 3) {
                $url = 'http://github.com/' . $this->args[1] . '/' . $this->args[2];
            }
            if ($zip = $this->_download($url)) {
                if ($this->_install($type, $zip)) {
                    if ($this->_activate($type, $zip)) {
                        $this->out(__d('atcmobile', 'Extension installed and activated.'));
                    }
                }
            }
        }
    }

    /**
     * Display help/options
     */
    public function getOptionParser()
    {
        return parent::getOptionParser()
            ->setDescription(__d('atcmobile', 'Download, Install & Activate Plugins & Themes'))
            ->addArguments([
                'type' => [
                    'help' => __d('atcmobile', 'Extension type'),
                    'required' => true,
                    'choices' => ['plugin', 'theme'],
                ],
                'zip_url' => [
                    'help' => __d('atcmobile', 'URL to zip file OR github user name'),
                    'required' => true,
                ],
                'github_package' => [
                    'help' => __d('atcmobile', 'Github repo name'),
                ],
            ]);
    }

    /**
     * Activates an extension by calling ExtShell
     *
     * @param string $type Type of extension
     * @param string $zip Path to zip file
     * @return bool
     */
    protected function _activate($type = null, $zip = null)
    {
        try {
            $ext = $this->_ExtensionsInstaller->{'get' . ucfirst($type) . 'Name'}($zip);
            $this->dispatchShell('ext', 'activate', $type, $ext, '--quiet');

            return true;
        } catch (Exception $e) {
            $this->err($e->getMessage());
        }

        return false;
    }

    /**
     * Extracts an extension
     *
     * @param string $type Type of extension
     * @param string $zip Path to zip file
     * @return bool
     */
    protected function _install($type = null, $zip = null)
    {
        $this->out(__d('atcmobile', 'Installing extension...'));
        try {
            $this->_ExtensionsInstaller->{'extract' . ucfirst($type)}($zip);

            return true;
        } catch (Exception $e) {
            $this->err($e->getMessage());
        }

        return false;
    }

    /**
     * Download an extension via CURL
     *
     * @param string $url URL of extension
     * @return string Path to zip file
     * @throws ConsoleException
     */
    protected function _download($url = null)
    {
        if (empty($url)) {
            throw new ConsoleException(__d('atcmobile', 'Please specify a URL to a zipball extension'));
        }
        $url = $this->_githubUrl($url);
        $filename = uniqid('atcmobile_') . '.zip';
        $zip = $this->tmpPath . $filename;
        $this->out(__d('atcmobile', 'Downloading extension to %s...', $zip));
        $res = $this->_shellExec('curl -L ' . $url . ' -o ' . $zip . ' 2>&1');

        return $res ? $zip : false;
    }

    /**
     * If Github url return url to zip
     *
     * @param string $url
     * @return string
     */
    protected function _githubUrl($url = null)
    {
        if (strpos($url, 'github.com') === false) {
            return $url;
        }
        if (substr($url, -1) === '/') {
            $url = substr($url, 0, -1);
        }
        if (substr($url, -4) === '.git') {
            $url = substr($url, 0, -4);
        }
        $url = str_replace('git://', 'https://', $url);

        return $url . '/zipball/master';
    }

    /**
     * Wrapper for shell_exec() method for testing
     */
    protected function _shellExec($cmd)
    {
        return shell_exec($cmd);
    }
}
