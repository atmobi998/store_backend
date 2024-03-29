<?php

namespace Atcmobapp\Extensions;

use Cake\Core\App;
use Cake\Filesystem\Folder;
use Atcmobapp\Core\Exception\Exception;
use ZipArchive;

/**
 * Extensions Installer
 *
 * @category Extensions.Model
 * @package  Atcmobapp.Extensions.Lib
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class ExtensionsInstaller
{

    /**
     * Cache last retrieved plugin names for paths
     *
     * @var array
     */
    protected $_pluginName = [];

    /**
     * Cache last retrieved theme names for paths
     *
     * @var array
     */
    protected $_themeName = [];

    /**
     * Holds the found root paths of checked zip file
     *
     * @var array
     */
    protected $_rootPath = [];

    /**
     * Hold instance of AtcmobappComposer
     *
     * @var AtcmobappComposer
     */
    protected $_AtcmobappComposer = null;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->_AtcmobappComposer = new AtcmobappComposer();
    }

    /**
     * Get Plugin Name from zip file
     *
     * @param string $path Path to zip file of plugin
     * @return string Plugin name
     * @throws Exception
     */
    public function getPluginName($path = null)
    {
        if (empty($path)) {
            throw new Exception(__d('atcmobile', 'Invalid plugin path'));
        }
        if (isset($this->_pluginName[$path])) {
            return $this->_pluginName[$path];
        }
        $Zip = new ZipArchive;
        if ($Zip->open($path) === true) {
            $search = 'config/plugin.json';
            $indexJson = $Zip->locateName('plugin.json', ZIPARCHIVE::FL_NODIR);
            if ($indexJson === false) {
                throw new Exception(__d('atcmobile', 'Invalid zip archive'));
            } else {
                $fileName = $Zip->getNameIndex($indexJson);
                $fileJson = json_decode($Zip->getFromIndex($indexJson));

                if (empty($fileJson->name)) {
                    throw new Exception(__d('atcmobile', 'Invalid plugin.json or missing plugin name'));
                }

                $this->_rootPath[$path] = str_replace($search, '', $fileName);
                $plugin = $fileJson->name;

                $searches = [
                    $plugin . 'Activation.php',
                    $plugin . 'AppController.php',
                    $plugin . 'AppModel.php',
                    $plugin . 'Helper.php'
                ];

                $hasFile = false;
                foreach ($searches as $search) {
                    if ($Zip->locateName($search, ZIPARCHIVE::FL_NODIR) !== false) {
                        $hasFile = true;
                        break;
                    }
                }
                if (!$hasFile) {
                    Log::critical(__d('atcmobile', 'Missing expected files: %s in: %s', implode(',', $searches), $path));
                    throw new Exception(__d('atcmobile', 'Invalid plugin or missing expected files'));
                }
            }
            $Zip->close();
            if (!$plugin) {
                throw new Exception(__d('atcmobile', 'Invalid plugin'));
            }
            $this->_pluginName[$path] = $plugin;

            return $plugin;
        } else {
            throw new Exception(__d('atcmobile', 'Invalid zip archive'));
        }

        return false;
    }

    /**
     * Extract a plugin from a zip file
     *
     * @param string $path Path to extension zip file
     * @param string $plugin Optional plugin name
     * @return bool
     * @throws Exception
     */
    public function extractPlugin($path = null, $plugin = null)
    {
        if (!file_exists($path)) {
            throw new Exception(__d('atcmobile', 'Invalid plugin file path'));
        }

        if (empty($plugin)) {
            $plugin = $this->getPluginName($path);
        }

        $pluginHome = App::path('Plugin');
        $pluginHome = reset($pluginHome);
        $pluginPath = $pluginHome . $plugin . DS;
        if (is_dir($pluginPath)) {
            throw new Exception(__d('atcmobile', 'Plugin already exists'));
        }

        $Zip = new ZipArchive;
        if ($Zip->open($path) === true) {
            new Folder($pluginPath, true);
            $Zip->extractTo($pluginPath);
            if (!empty($this->_rootPath[$path])) {
                $old = $pluginPath . $this->_rootPath[$path];
                $new = $pluginPath;
                $Folder = new Folder($old);
                $Folder->move($new);
            }
            $Zip->close();

            return true;
        } else {
            throw new Exception(__d('atcmobile', 'Failed to extract plugin'));
        }

        return false;
    }

    /**
     * Get name of theme
     *
     * @param string $path Path to zip file of theme
     * @throws Exception
     */
    public function getThemeName($path = null)
    {
        if (empty($path)) {
            throw new Exception(__d('atcmobile', 'Invalid theme path'));
        }

        if (isset($this->_themeName[$path])) {
            return $this->_themeName[$path];
        }

        $Zip = new ZipArchive;
        if ($Zip->open($path) === true) {
            $search = 'webroot/theme.json';
            $index = $Zip->locateName('theme.json', ZIPARCHIVE::FL_NODIR);
            if ($index !== false) {
                $file = $Zip->getNameIndex($index);
                $this->_rootPath[$path] = str_replace($search, '', $file);
                $json = json_decode($Zip->getFromIndex($index));
                if (!empty($json->name)) {
                    $theme = $json->name;
                }
            }
            $Zip->close();
            if (!$theme) {
                throw new Exception(__d('atcmobile', 'Invalid theme'));
            }
            $this->_themeName[$path] = $theme;

            return $theme;
        } else {
            throw new Exception(__d('atcmobile', 'Invalid zip archive'));
        }

        return false;
    }

    /**
     * Extract a theme from a zip file
     *
     * @param string $path Path to extension zip file
     * @param string $theme Optional theme name
     * @return bool
     * @throws Exception
     */
    public function extractTheme($path = null, $theme = null)
    {
        if (!file_exists($path)) {
            throw new Exception(__d('atcmobile', 'Invalid theme file path'));
        }

        if (empty($theme)) {
            $theme = $this->getThemeName($path);
        }

        $themeHome = App::path('Plugin');
        $themeHome = reset($themeHome);
        $themePath = $themeHome . $theme . DS;
        if (is_dir($themePath)) {
            throw new Exception(__d('atcmobile', 'Theme already exists'));
        }

        $Zip = new ZipArchive;
        if ($Zip->open($path) === true) {
            new Folder($themePath, true);
            $Zip->extractTo($themePath);
            if (!empty($this->_rootPath[$path])) {
                $old = $themePath . $this->_rootPath[$path];
                $new = $themePath;
                $Folder = new Folder($old);
                $Folder->move($new);
            }
            $Zip->close();

            return true;
        } else {
            throw new Exception(__d('atcmobile', 'Failed to extract theme'));
        }

        return false;
    }

    /**
     * Install packages with AtcmobappComposer
     *
     * @param array $data
     * @return bool
     * @throws Exception
     */
    public function composerInstall($data = [])
    {
        $data = array_merge([
            'package' => '',
            'version' => '*',
            'type' => 'plugin',
        ], $data);
        if (empty($data['package']) || strpos($data['package'], '/') === false) {
            throw new Exception(__d('atcmobile', 'Must specify a valid package name: vendor/name.'));
        }
        if ($data['type'] == 'theme') {
            throw new Exception(__d('atcmobile', 'Themes installed via composer are not yet supported.'));
        }
        $this->_AtcmobappComposer->getComposer();
        $this->_AtcmobappComposer->setConfig([
            $data['package'] => $data['version'],
        ]);

        return $this->_AtcmobappComposer->runComposer();
    }
}
