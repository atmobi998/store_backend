<?php

namespace Atcmobapp\Core;

use Cake\Core\BasePlugin;
use Cake\Core\Configure;
use Cake\Core\PluginApplicationInterface;
use Cake\Utility\Security;

class Plugin extends BasePlugin
{

    public function bootstrap(PluginApplicationInterface $app)
    {
        parent::bootstrap($app);

        timerStart('Atcmobapp bootstrap');
        PluginManager::setup($app);
        PluginManager::atcmobileBootstrap($app);
        timerStop('Atcmobapp bootstrap');

        // Load Install plugin
        $salted = Security::getSalt() !== '__SALT__';
        if (!Configure::read('Atcmobapp.installed') || !$salted) {
            $app->addPlugin('Atcmobapp/Install', ['routes' => true, 'bootstrap' => true]);
        }
    }

    /**
     * @param \Cake\Routing\RouteBuilder $routes The route builder to update.
     * @return void
     */
    public function routes($routes)
    {
        parent::routes($routes);
        Router::homepage();
    }

}
