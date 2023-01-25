<?php

use Cake\Routing\RouteBuilder;
use Atcmobapp\Core\Router;

Router::plugin('Atcmobapp/Contacts', ['path' => '/'], function (RouteBuilder $route) {
    $route->prefix('admin', function (RouteBuilder $route) {
        $route->setExtensions(['json']);
        $route->applyMiddleware('csrf');

        $route->scope('/contacts', [], function (RouteBuilder $route) {
            $route->fallbacks();
        });
    });

    Router::build($route, '/contact', ['controller' => 'Contacts', 'action' => 'view', 'contact']);
    Router::build($route, '/contact/*', ['controller' => 'Contacts', 'action' => 'view']);
});
