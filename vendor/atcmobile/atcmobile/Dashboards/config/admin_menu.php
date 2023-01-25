<?php

use Atcmobapp\Core\Nav;

Nav::add('sidebar', 'dashboard', [
    'icon' => 'home',
    'title' => __d('atcmobile', 'Dashboard'),
    'url' => '/admin',
    'weight' => 0,
]);

Nav::add('sidebar', 'settings.children.dashboard', [
    'title' => __d('atcmobile', 'Dashboard'),
    'url' => [
        'plugin' => 'Atcmobapp/Dashboards',
        'controller' => 'Dashboards',
        'action' => 'index',
    ],
]);
