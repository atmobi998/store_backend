<?php

namespace Atcmobapp\Menus\Config;

use Atcmobapp\Core\Nav;

Nav::add('sidebar', 'menus', [
    'icon' => 'sitemap',
    'title' => __d('atcmobile', 'Menus'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Atcmobapp/Menus',
        'controller' => 'Menus',
        'action' => 'index',
    ],
    'weight' => 20,
    'children' => [
        'menus' => [
            'title' => __d('atcmobile', 'Menus'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Menus',
                'controller' => 'Menus',
                'action' => 'index',
            ],
            'weight' => 10,
        ],
    ],
]);
