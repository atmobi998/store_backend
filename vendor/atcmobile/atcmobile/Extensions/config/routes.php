<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin('Atcmobapp/Extensions', ['path' => '/'], function (RouteBuilder $route) {
    $route->prefix('admin', function (RouteBuilder $route) {
        $route->setExtensions(['json']);
        $route->applyMiddleware('csrf');

        $route->scope('/extensions', [], function (RouteBuilder $route) {
            $route->fallbacks();
        });
    });
});
