<?php

namespace Atcmobapp\FileManager\Config;

use Atcmobapp\Core\Nav;

Nav::add('sidebar', 'media', [
    'icon' => 'image',
    'title' => __d('atcmobile', 'Media'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Atcmobapp/FileManager',
        'controller' => 'Attachments',
        'action' => 'index',
    ],
    'weight' => 40,
    'children' => [
        'attachments' => [
            'title' => __d('atcmobile', 'Attachments'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/FileManager',
                'controller' => 'Attachments',
                'action' => 'index',
            ],
        ],
        'file_manager' => [
            'title' => __d('atcmobile', 'File Manager'),
            'url' => [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/FileManager',
                'controller' => 'FileManager',
                'action' => 'browse',
            ],
        ],
    ],
]);
