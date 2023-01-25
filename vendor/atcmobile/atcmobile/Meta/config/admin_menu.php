<?php

namespace Atcmobapp\Menus\Config;

use Atcmobapp\Core\Nav;

Nav::add('sidebar', 'settings.children.meta', [
    'title' => __d('atcmobile', 'Meta'),
    'url' => [
        'prefix' => 'admin',
        'plugin' => 'Atcmobapp/Meta',
        'controller' => 'Meta',
        'action' => 'index',
    ],
    'weight' => 20,
]);
