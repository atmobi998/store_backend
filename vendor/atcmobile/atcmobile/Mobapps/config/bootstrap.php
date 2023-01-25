<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Atcmobapp\Core\Atcmobapp;
use Atcmobapp\Wysiwyg\Wysiwyg;

$cacheConfig = array_merge(
    Configure::read('Atcmobapp.Cache.defaultConfig'),
    ['groups' => ['Mobapps']]
);
Cache::setConfig('Mobapps', $cacheConfig);
Cache::setConfig('Mobapps_view', $cacheConfig);
Cache::setConfig('Mobapps_edit', $cacheConfig);
Cache::setConfig('Mobapps_add', $cacheConfig);
Cache::setConfig('Mobapps_promoted', $cacheConfig);
Cache::setConfig('Mobapps_term', $cacheConfig);
Cache::setConfig('Mobapps_index', $cacheConfig);

Atcmobapp::hookApiComponent('Atcmobapp/Mobapps.Mobapps', 'Mobapps.MobappApi');
Atcmobapp::hookComponent('*', [
    'MobappsHook' => [
        'className' => 'Atcmobapp/Mobapps.Mobapps'
    ]
]);

Atcmobapp::hookHelper('*', 'Atcmobapp/Mobapps.Mobapps');


