<?php

namespace Atcmobapp\Contacts\Config;

use Atcmobapp\Core\Nav;

Nav::add('sidebar', 'contacts', [
    'icon' => 'comments',
    'title' => __d('atcmobile', 'Contacts'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Atcmobapp/Contacts',
        'controller' => 'Contacts',
        'action' => 'index',
    ],
    'weight' => 50,
    'children' => [
        'contacts' => [
            'title' => __d('atcmobile', 'Contacts'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Contacts',
                'controller' => 'Contacts',
                'action' => 'index',
            ],
        ],
        'messages' => [
            'title' => __d('atcmobile', 'Messages'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Contacts',
                'controller' => 'Messages',
                'action' => 'index',
            ],
        ],
    ],
]);
