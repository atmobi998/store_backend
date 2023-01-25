<?php

namespace Atcmobapp\Settings\Config;

use Atcmobapp\Core\Nav;

Nav::add('sidebar', 'settings', [
    'icon' => 'cog',
    'title' => __d('atcmobile', 'Settings'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Atcmobapp/Settings',
        'controller' => 'Settings',
        'action' => 'prefix',
        'Site',
    ],
    'weight' => 60,
    'children' => [
        'site' => [
            'title' => __d('atcmobile', 'Site'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Settings',
                'controller' => 'Settings',
                'action' => 'prefix',
                'Site',
            ],
            'weight' => 10,
        ],

        'theme' => [
            'title' => __d('atcmobile', 'Theme'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Settings',
                'controller' => 'Settings',
                'action' => 'prefix',
                'Theme',
            ],
            'weight' => 15,
        ],

        'reading' => [
            'title' => __d('atcmobile', 'Reading'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Settings',
                'controller' => 'Settings',
                'action' => 'prefix',
                'Reading',
            ],
            'weight' => 30,
        ],

        'comment' => [
            'title' => __d('atcmobile', 'Comment'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Settings',
                'controller' => 'Settings',
                'action' => 'prefix',
                'Comment',
            ],
            'weight' => 50,
        ],

        'service' => [
            'title' => __d('atcmobile', 'Service'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Settings',
                'controller' => 'Settings',
                'action' => 'prefix',
                'Service',
            ],
            'weight' => 60,
        ],

        'languages' => [
            'title' => __d('atcmobile', 'Languages'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Settings',
                'controller' => 'Languages',
                'action' => 'index',
            ],
            'weight' => 70,
        ],

        'cache' => [
            'title' => __d('atcmobile', 'Cache'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Settings',
                'controller' => 'Caches',
                'action' => 'index',
            ],
            'weight' => 70,
        ],

    ],
]);
