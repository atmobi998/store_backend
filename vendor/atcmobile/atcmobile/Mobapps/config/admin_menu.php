<?php

namespace Atcmobapp\Mobapps\Config;

use Atcmobapp\Core\Nav;

Nav::add('sidebar', 'street', [
    'icon' => 'edit',
    'title' => __d('atcmobapp', 'Mobapps'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Atcmobapp/Mobapps',
        'controller' => 'Mobapps',
        'action' => 'index',
    ],
    'weight' => 90,
    'children' => [
        'list' => [
            'title' => __d('atcmobapp', 'Mobapps'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Mobapps',
                'controller' => 'Mobapps',
                'action' => 'index',
            ],
            'weight' => 90,
        ],
        'create' => [
            'title' => __d('atcmobapp', 'UI'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Mobapps',
                'controller' => 'Mobapps',
                'action' => 'create',
            ],
            'weight' => 100,
        ],
    ]
]);
