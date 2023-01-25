<?php

use Cake\Routing\RouteBuilder;
use Atcmobapp\Core\Router;

Router::plugin('Atcmobapp/Users', ['path' => '/'], function (RouteBuilder $route) {
	$route->prefix('admin', function (RouteBuilder $route) {
		$route->setExtensions(['json']);
		$route->applyMiddleware('csrf');

		$route->scope('/users', [], function (RouteBuilder $route) {
		    $route->fallbacks();
		});
	});

	Router::build($route, '/register', ['controller' => 'Users', 'action' => 'add']);
	Router::build($route, '/user/:username', ['controller' => 'Users', 'action' => 'view'], ['pass' => ['username']]);

	Router::build($route, '/users', ['controller' => 'Users', 'action' => 'index']);
	Router::build($route, '/users/:action/*', ['controller' => 'Users']);
    
});

