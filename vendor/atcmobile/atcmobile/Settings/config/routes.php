<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin('Atcmobapp/Settings', ['path' => '/'], function (RouteBuilder $route) {
    $route->prefix('admin', function (RouteBuilder $route) {
        $route->setExtensions(['json']);
        $route->applyMiddleware('csrf');

        $route->scope('/settings', [], function (RouteBuilder $route) {
            $route->fallbacks();
        });
    });
});
