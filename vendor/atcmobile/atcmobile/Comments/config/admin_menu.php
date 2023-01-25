<?php

namespace Atcmobapp\Comments\Config;

use Atcmobapp\Core\Nav;

Nav::add('sidebar', 'content.children.comments', [
    'title' => __d('atcmobile', 'Comments'),
    'url' => [
        'admin' => true,
        'plugin' => 'Atcmobapp/Comments',
        'controller' => 'Comments',
        'action' => 'index',
    ],
    'children' => [
        'published' => [
            'title' => __d('atcmobile', 'Published'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Comments',
                'controller' => 'Comments',
                'action' => 'index',
                '?' => [
                    'status' => '1',
                ],
            ],
        ],
        'approval' => [
            'title' => __d('atcmobile', 'Approval'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Comments',
                'controller' => 'Comments',
                'action' => 'index',
                '?' => [
                    'status' => '0',
                ],
            ],
        ],
    ],
]);
