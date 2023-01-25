<?php

namespace Atcmobapp\Extensions\Event;

use Cake\Core\Plugin;
use Cake\Event\EventListenerInterface;
use Atcmobapp\Core\PluginManager;

/**
 * ExtensionsEventHandler
 *
 * @package  Atcmobapp.Extensions.Event
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class ExtensionsEventHandler implements EventListenerInterface
{

    /**
     * implementedEvents
     */
    public function implementedEvents()
    {
        return [
            'Atcmobapp.bootstrapComplete' => [
                'callable' => 'onBootstrapComplete',
            ],
            'Atcmobapp.beforeSetupAdminData' => [
                'callable' => 'onBeforeSetupAdminData',
            ],
            'Atcmobapp.setupAdminData' => [
                'callable' => 'onSetupAdminData',
            ],
        ];
    }

    /**
     * Before Setup admin data
     */
    public function onBeforeSetupAdminData($event)
    {
        $plugins = Plugin::loaded();
        $config = 'config' . DS . 'admin.php';
        foreach ($plugins as $plugin) {
            $file = Plugin::path($plugin) . $config;
            if (file_exists($file)) {
                require $file;
            }
        }
    }

    /**
     * Setup admin data
     */
    public function onSetupAdminData($event)
    {
        $plugins = Plugin::loaded();
        $config = 'config' . DS . 'admin_menu.php';
        foreach ($plugins as $plugin) {
            $file = Plugin::path($plugin) . $config;
            if (file_exists($file)) {
                require $file;
            }
        }
        $file = sprintf('%s/%s', ROOT, $config);
        if (file_exists($file)){
            require $file;
        }
    }

    /**
     * onBootstrapComplete
     */
    public function onBootstrapComplete($event)
    {
        PluginManager::cacheDependencies();
    }
}
