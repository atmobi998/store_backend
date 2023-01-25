<?php

namespace Atcmobapp\Extensions\Config;

use Atcmobapp\Core\Nav;

Nav::add('sidebar', 'extensions', [
    'icon' => 'magic',
    'title' => __d('atcmobile', 'Extensions'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Atcmobapp/Extensions',
        'controller' => 'Plugins',
        'action' => 'index',
    ],
    'weight' => 35,
    'children' => [
        'themes' => [
            'title' => __d('atcmobile', 'Themes'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Extensions',
                'controller' => 'Themes',
                'action' => 'index',
            ],
            'weight' => 10,
        ],
        'locales' => [
            'title' => __d('atcmobile', 'Locales'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Extensions',
                'controller' => 'Locales',
                'action' => 'index',
            ],
            'weight' => 20,
        ],
        'plugins' => [
            'title' => __d('atcmobile', 'Plugins'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Extensions',
                'controller' => 'Plugins',
                'action' => 'index',
            ],
            'htmlAttributes' => [
                'class' => 'separator',
            ],
            'weight' => 30,
        ],
    ],
]);
