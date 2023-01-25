<?php

namespace Atcmobapp\Acl\Config;

use Atcmobapp\Core\Nav;

Nav::add('sidebar', 'users.children.permissions', [
    'title' => __d('atcmobile', 'Permissions'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Atcmobapp/Acl',
        'controller' => 'Permissions',
        'action' => 'index',
    ],
    'weight' => 30,
]);

Nav::add('sidebar', 'settings.children.acl', [
    'title' => __d('atcmobile', 'Access Control'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Atcmobapp/Settings',
        'controller' => 'Settings',
        'action' => 'prefix',
        'Access Control',
    ],
]);
