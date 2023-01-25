<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Atcmobapp\Core\Atcmobapp;

Cache::setConfig('atcmobile_menus', array_merge(
    Configure::read('Atcmobapp.Cache.defaultConfig'),
    ['groups' => ['menus']]
));

Atcmobapp::hookComponent('*', 'Atcmobapp/Menus.Menu');

Atcmobapp::hookHelper('*', 'Atcmobapp/Menus.Menus');

Atcmobapp::translateModel('Atcmobapp/Menus.Links', [
    'fields' => [
        'title',
        'description',
    ],
]);
