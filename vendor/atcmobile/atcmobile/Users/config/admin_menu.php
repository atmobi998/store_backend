<?php

namespace Atcmobapp\Users\Config;

use Atcmobapp\Core\Nav;

Nav::add('sidebar', 'users', [
    'icon' => 'user',
    'title' => __d('atcmobile', 'Users'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Atcmobapp/Users',
        'controller' => 'Users',
        'action' => 'index',
    ],
    'weight' => 50,
    'children' => [
        'users' => [
            'title' => __d('atcmobile', 'Users'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Users',
                'controller' => 'Users',
                'action' => 'index',
            ],
            'weight' => 10,
        ],
        'roles' => [
            'title' => __d('atcmobile', 'Roles'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Users',
                'controller' => 'Roles',
                'action' => 'index',
            ],
            'weight' => 20,
        ],
    ],
]);
