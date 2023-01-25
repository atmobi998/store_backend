<?php

namespace Atcmobapp\Taxonomy\Config;

use Atcmobapp\Core\Nav;

Nav::add('sidebar', 'content.children.content_types', [
    'title' => __d('atcmobile', 'Content Types'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Atcmobapp/Taxonomy',
        'controller' => 'Types',
        'action' => 'index',
    ],
    'weight' => 30,
]);

Nav::add('sidebar', 'content.children.taxonomy', [
    'title' => __d('atcmobile', 'Taxonomy'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Atcmobapp/Taxonomy',
        'controller' => 'Vocabularies',
        'action' => 'index',
    ],
    'weight' => 40,
    'children' => [
        'list' => [
            'title' => __d('atcmobile', 'List'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Taxonomy',
                'controller' => 'Vocabularies',
                'action' => 'index',
            ],
            'weight' => 10,
        ],
        'add_new' => [
            'title' => __d('atcmobile', 'Add new'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Taxonomy',
                'controller' => 'Vocabularies',
                'action' => 'add',
            ],
            'weight' => 20,
            'htmlAttributes' => ['class' => 'separator'],
        ]
    ]
]);
