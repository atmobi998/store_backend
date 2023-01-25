<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Atcmobapp\Core\Atcmobapp;

$cacheConfig = array_merge(
    Configure::read('Atcmobapp.Cache.defaultConfig'),
    ['groups' => ['taxonomy']]
);
Cache::setConfig('atcmobile_types', $cacheConfig);
Cache::setConfig('atcmobile_vocabularies', $cacheConfig);

Atcmobapp::hookComponent('*', 'Atcmobapp/Taxonomy.Taxonomy');

Atcmobapp::hookHelper('*', 'Atcmobapp/Taxonomy.Taxonomies');

Atcmobapp::translateModel('Atcmobapp/Taxonomy.Terms', [
    'fields' => [
        'title',
        'description',
    ],
]);

Atcmobapp::translateModel('Atcmobapp/Taxonomy.Types', [
    'fields' => [
        'title',
        'description',
    ],
]);
