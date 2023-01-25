<?php

namespace Atcmobapp\Blocks\Config;

use Atcmobapp\Core\Nav;

Nav::add('sidebar', 'blocks', [
    'icon' => 'columns',
    'title' => __d('atcmobile', 'Blocks'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Atcmobapp/Blocks',
        'controller' => 'Blocks',
        'action' => 'index',
    ],
    'weight' => 30,
    'children' => [
        'blocks' => [
            'title' => __d('atcmobile', 'Blocks'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Blocks',
                'controller' => 'Blocks',
                'action' => 'index',
            ],
        ],
        'regions' => [
            'title' => __d('atcmobile', 'Regions'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Blocks',
                'controller' => 'Regions',
                'action' => 'index',
            ],
        ],
    ],
]);
