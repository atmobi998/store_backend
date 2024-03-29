<?php

namespace Atcmobapp\Install;

use Cake\Composer\Installer\PluginInstaller;
use Composer\Composer;
use Composer\Script\Event;
use DirectoryIterator;

/**
 * Class ComposerInstaller
 */
class ComposerInstaller extends PluginInstaller
{

    /**
     * @param Event $event
     * @return void
     */
    public static function postAutoloadDump(Event $event)
    {
        $composer = $event->getComposer();
        $config = $composer->getConfig();
        $vendorDir = realpath($config->get('vendor-dir'));
        $atcmobileDir = dirname(dirname(__DIR__));
        $packages = $composer->getRepositoryManager()->getLocalRepository()->getPackages();
        $pluginsDir = dirname($vendorDir) . DIRECTORY_SEPARATOR . 'plugins';
        $plugins = static::determinePlugins($packages, $pluginsDir, $vendorDir);
        $corePlugins = [
            'Acl', 'Blocks', 'Comments', 'Contacts', 'Core', 'Dashboards',
            'Extensions', 'FileManager', 'Install', 'Menus',
            'Mobapps', 'Meta', 'Nodes', 'Settings', 'Taxonomy', 'Translate', 'Users',
            'Wysiwyg',
        ];
        foreach ($corePlugins as $plugin) {
            $plugins['Atcmobapp\\' . $plugin] = $atcmobileDir . DIRECTORY_SEPARATOR . $plugin;
        }
        $configFile = static::_configFile($vendorDir);
        static::writeConfigFile($configFile, $plugins);
    }

    /**
     * Find all plugins available
     *
     * Add all composer packages of type cakephp-plugin, and all plugins located
     * in the plugins directory to a plugin-name indexed array of paths
     *
     * @param array $packages an array of \Composer\Package\PackageInterface objects
     * @param string $pluginsDir the path to the plugins dir
     * @param string $vendorDir the path to the vendor dir
     * @return array plugin-name indexed paths to plugins
     */
    public static function determinePlugins($packages, $pluginsDir = 'plugins', $vendorDir = 'vendor')
    {
        $plugins = [];

        foreach ($packages as $package) {
            if (!in_array($package->getType(), ['cakephp-plugin', 'atcmobile-plugin', 'atcmobile-theme'])) {
                continue;
            }

            $ns = static::primaryNamespace($package);
            $path = $vendorDir . DIRECTORY_SEPARATOR . $package->getPrettyName();
            $plugins[$ns] = $path;
        }

        if (is_dir($pluginsDir)) {
            $dir = new DirectoryIterator($pluginsDir);
            foreach ($dir as $info) {
                if (!$info->isDir() || $info->isDot()) {
                    continue;
                }

                $name = $info->getFilename();
                $plugins[$name] = $pluginsDir . DIRECTORY_SEPARATOR . $name;
            }
        }

        ksort($plugins);

        return $plugins;
    }
}
