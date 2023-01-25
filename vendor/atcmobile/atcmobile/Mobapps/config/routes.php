<?php

use Cake\Routing\RouteBuilder;
use Atcmobapp\Core\Router;

Router::plugin('Atcmobapp/Mobapps', ['path' => '/'], function (RouteBuilder $route) {

	$route->prefix('admin', function (RouteBuilder $route) {
		$route->setExtensions(['json']);
		$route->applyMiddleware('csrf');
		$route->scope('/mobapps', [], function (RouteBuilder $route) {
		    $route->fallbacks();
		});
	});
    		
	$strsroutebldacts = array('register', 'forgot', 'login', 'token', 'userinfo', 'listbyemail', 'profileedit');
	foreach ($strsroutebldacts as $strsroutebldact) {
		$route->connect('/profile/'.$strsroutebldact.'/*', ['controller' => 'Profiles', 'action' => $strsroutebldact]);
	}
	
	$strsroutebldacts = array('addapp', 'delapp', 'editapp', 'getapp', 'appqry', 'register', 'login', 'token', 'userinfo', 'listbyemail');
	foreach ($strsroutebldacts as $strsroutebldact) {
		$route->connect('/mobapp/'.$strsroutebldact.'/*', ['controller' => 'Mobapps', 'action' => $strsroutebldact]);
	}

	$strsroutebldacts = array('postoken', 'addpos', 'editpos', 'posqry', 'addstore', 'delstore', 'editstore', 'getstore', 'storeqry');
	foreach ($strsroutebldacts as $strsroutebldact) {
		$route->connect('/mobstore/'.$strsroutebldact.'/*', ['controller' => 'Mobstores', 'action' => $strsroutebldact]);
	}

	$strsroutebldacts = array( 'postoken', 'addsess', 'editsess', 'sessqry', 'addprod', 'editprod', 'prodqry', 'addcat', 'delcat', 'editcat', 'catqry', 'detadd', 'detdel', 'detedit', 'detqry', 'tktadd', 'tktedit', 'tktqry' );
	foreach ($strsroutebldacts as $strsroutebldact) {
		$route->connect('/mobpos/'.$strsroutebldact.'/*', ['controller' => 'Mobposctls', 'action' => $strsroutebldact]);
	}

	$strsroutebldacts = array( 'usrtoken', 'postoken', 'addsess', 'editsess', 'sessqry', 'addprod', 'editprod', 'prodqry', 'addcat', 'delcat', 'editcat', 'catqry', 'detadd', 'detdel', 'detedit', 'detqry', 'tktadd', 'tktedit', 'tktqry' );
	foreach ($strsroutebldacts as $strsroutebldact) {
		$route->connect('/mobusr/'.$strsroutebldact.'/*', ['controller' => 'Mobusrctls', 'action' => $strsroutebldact]);
	}

	$strsroutebldacts = array( 'usrtoken', 'postoken', 'addsess', 'editsess', 'sessqry', 'addprod', 'editprod', 'prodqry', 'addcat', 'delcat', 'editcat', 'catqry', 'orddetadd', 'orddetdel', 'orddetedit', 'orddetqry', 'ordadd', 'ordedit', 'ordqry', 'produpd' );
	foreach ($strsroutebldacts as $strsroutebldact) {
		$route->connect('/mobrescaf/'.$strsroutebldact.'/*', ['controller' => 'Mobrescafs', 'action' => $strsroutebldact]);
	}

	$strsroutebldacts = array('addcat', 'delcat', 'editcat', 'getcat', 'catqry');
	foreach ($strsroutebldacts as $strsroutebldact) {
		$route->connect('/mobcat/'.$strsroutebldact.'/*', ['controller' => 'Mobcats', 'action' => $strsroutebldact]);
	}

	$strsroutebldacts = array('addprod', 'delprod', 'editprod', 'getprod', 'prodqry');
	foreach ($strsroutebldacts as $strsroutebldact) {
		$route->connect('/mobprod/'.$strsroutebldact.'/*', ['controller' => 'Mobprods', 'action' => $strsroutebldact]);
	}

	$strsroutebldacts = array('addprdopt', 'delprdopt', 'editprdopt', 'getprdopt', 'prdoptqry');
	foreach ($strsroutebldacts as $strsroutebldact) {
		$route->connect('/mobprdopt/'.$strsroutebldact.'/*', ['controller' => 'Mobprdopts', 'action' => $strsroutebldact]);
	}

	$strsroutebldacts = array('addord', 'delord', 'editord', 'getord', 'ordqry');
	foreach ($strsroutebldacts as $strsroutebldact) {
		$route->connect('/mobord/'.$strsroutebldact.'/*', ['controller' => 'Mobords', 'action' => $strsroutebldact]);
	}

	$strsroutebldacts = array('addordprd', 'delordprd', 'editordprd', 'getordprd', 'ordprdqry');
	foreach ($strsroutebldacts as $strsroutebldact) {
		$route->connect('/mobordprd/'.$strsroutebldact.'/*', ['controller' => 'Mobordprds', 'action' => $strsroutebldact]);
	}

	$strsroutebldacts = array('addsupl', 'delsupl', 'editsupl', 'getsupl', 'suplqry');
	foreach ($strsroutebldacts as $strsroutebldact) {
		$route->connect('/mobsupl/'.$strsroutebldact.'/*', ['controller' => 'Mobsuppls', 'action' => $strsroutebldact]);
	}

	$strsroutebldacts = array('addcart', 'delcart', 'editcart', 'getcart', 'cartqry');
	foreach ($strsroutebldacts as $strsroutebldact) {
		$route->connect('/mobcart/'.$strsroutebldact.'/*', ['controller' => 'Mobcarts', 'action' => $strsroutebldact]);
	}

	$strsroutebldacts = array('login','token','clicab','cabqry','drvqry','upfund','transqry','balance','addcli','delcli','editcli','getcli','cliqry','homeloc','cliloc','editnid','editpay');
	foreach ($strsroutebldacts as $strsroutebldact) {
		$route->connect('/mobcli/'.$strsroutebldact.'/*', ['controller' => 'Mobclis', 'action' => $strsroutebldact]);
	}

	$strsroutebldacts = array('login','token','upfund','transqry','balance','adddrv','deldrv','editdrv','getdrv','drvqry','homeloc','drvcab','cabqry',
								'drvloc','editnid','editpay','editcar','editcarlic','editbike','editbikelic');
	foreach ($strsroutebldacts as $strsroutebldact) {
		$route->connect('/mobdrv/'.$strsroutebldact.'/*', ['controller' => 'Mobdrvs', 'action' => $strsroutebldact]);
	}
	
	$strsroutebldacts = array('addcab', 'delcab', 'editcab', 'getcab', 'cabqry');
	foreach ($strsroutebldacts as $strsroutebldact) {
		$route->connect('/mobcab/'.$strsroutebldact.'/*', ['controller' => 'Mobcabs', 'action' => $strsroutebldact]);
	}

});


