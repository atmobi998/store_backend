<?php

use Cake\Routing\RouteBuilder;
use Atcmobapp\Core\Router;

Router::plugin('Atcmobapp/Comments', ['path' => '/'], function (RouteBuilder $route) {
    $route->prefix('admin', function (RouteBuilder $route) {
        $route->setExtensions(['json']);
        $route->applyMiddleware('csrf');
        $route->scope('/comments', [], function (RouteBuilder $route) {
            $route->fallbacks();
        });
    });

    $route->setExtensions(['rss']);
    $route->scope('/comments', [], function (RouteBuilder $route) {
        Router::build($route, '/', ['controller' => 'Comments']);
        $route->fallbacks();
    });
});
