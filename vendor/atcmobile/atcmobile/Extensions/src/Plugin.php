<?php

namespace Atcmobapp\Extensions;

use Cake\Core\BasePlugin;
use Cake\Core\PluginApplicationInterface;
use Cake\Core\Plugin as CakePlugin;

class Plugin extends BasePlugin
{

    public function bootstrap(PluginApplicationInterface $app)
    {
        if (!CakePlugin::isLoaded('Migrations')) {
            $app->addPlugin('Migrations', ['autoload' => true, 'classBase' => false]);
        }
        if (!CakePlugin::isLoaded('Atcmobapp/Settings')) {
            $app->addPlugin('Atcmobapp/Settings', ['bootstrap' => true, 'routes' => true]);
        }
        if (!CakePlugin::isLoaded('Search')) {
            $app->addPlugin('Search', ['autoload' => true, 'classBase' => false]);
        }
    }
}
