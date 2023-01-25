<?php

namespace Atcmobapp\Nodes\Config;

use Atcmobapp\Core\Nav;

Nav::add('sidebar', 'content', [
    'icon' => 'edit',
    'title' => __d('atcmobile', 'Content'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Atcmobapp/Nodes',
        'controller' => 'Nodes',
        'action' => 'index',
    ],
    'weight' => 10,
    'children' => [
        'list' => [
            'title' => __d('atcmobile', 'List'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Nodes',
                'controller' => 'Nodes',
                'action' => 'index',
            ],
            'weight' => 10,
        ],
        'create' => [
            'title' => __d('atcmobile', 'Create'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Nodes',
                'controller' => 'Nodes',
                'action' => 'create',
            ],
            'weight' => 20,
        ],
    ]
]);
