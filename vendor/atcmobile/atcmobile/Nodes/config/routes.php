<?php

use Cake\Routing\RouteBuilder;
use Atcmobapp\Core\Router;

Router::plugin('Atcmobapp/Nodes', ['path' => '/'], function (RouteBuilder $route) {
    $route->prefix('admin', function (RouteBuilder $route) {
        $route->setExtensions(['json']);
        $route->applyMiddleware('csrf');

        $route->scope('/nodes', [], function (RouteBuilder $route) {
            $route->fallbacks();
        });
    });

    $route->setExtensions(['rss']);

    Router::build($route, '/', ['controller' => 'Nodes', 'action' => 'promoted']);
    Router::build($route, '/feed', ['controller' => 'Nodes', 'action' => 'feed', '_ext' => 'rss']);
    Router::build($route, '/search', ['controller' => 'Nodes', 'action' => 'search']);
    Router::routableContentTypes($route);
    
});

