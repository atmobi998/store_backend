<?php

use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;

Router::plugin('Atcmobapp/Taxonomy', ['path' => '/'], function (RouteBuilder $route) {
	$route->prefix('admin', function (RouteBuilder $route) {
		$route->setExtensions(['json']);
		$route->applyMiddleware('csrf');
		$route->scope('/taxonomy', [], function (RouteBuilder $route) {
		    $route->fallbacks();
		});
	});
});

