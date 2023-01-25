<?php

use Cake\Cache\Cache;
use Atcmobapp\Core\Atcmobapp;

Cache::setConfig('atcmobile_blocks', array_merge(
    Cache::getConfig('default'),
    ['groups' => ['blocks']]
));

Atcmobapp::hookComponent('*', [
    'BlocksHook' => [
        'className' => 'Atcmobapp/Blocks.Blocks',
        'priority' => 9,
    ]
]);

Atcmobapp::hookHelper('*', 'Atcmobapp/Blocks.Regions');

Atcmobapp::translateModel('Atcmobapp/Blocks.Blocks', [
    'fields' => [
        'title',
        'body',
    ],
    'allowEmptyTranslations' => false,
]);
