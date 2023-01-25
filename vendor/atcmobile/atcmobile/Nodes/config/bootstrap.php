<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Atcmobapp\Core\Atcmobapp;
use Atcmobapp\Wysiwyg\Wysiwyg;

$cacheConfig = array_merge(
    Configure::read('Atcmobapp.Cache.defaultConfig'),
    ['groups' => ['nodes']]
);
Cache::setConfig('nodes', $cacheConfig);
Cache::setConfig('nodes_view', $cacheConfig);
Cache::setConfig('nodes_promoted', $cacheConfig);
Cache::setConfig('nodes_term', $cacheConfig);
Cache::setConfig('nodes_index', $cacheConfig);

Atcmobapp::hookApiComponent('Atcmobapp/Nodes.Nodes', 'Nodes.NodeApi');
Atcmobapp::hookComponent('*', [
    'NodesHook' => [
        'className' => 'Atcmobapp/Nodes.Nodes'
    ]
]);

Atcmobapp::hookHelper('*', 'Atcmobapp/Nodes.Nodes');

// Configure Wysiwyg
Wysiwyg::setActions([
    'Atcmobapp/Nodes.Admin/Nodes/add' => [
        [
            'elements' => '#NodeBody',
        ],
        [
            'elements' => '#NodeExcerpt',
        ],
    ],
    'Atcmobapp/Nodes.Admin/Nodes/edit' => [
        [
            'elements' => '#NodeBody',
        ],
        [
            'elements' => '#NodeExcerpt',
        ],
    ],
    'Atcmobapp/Translate.Admin/Translate/edit' => [
        [
            'elements' => "[id^='translations'][id$='body']",
        ],
        [
            'elements' => "[id^='translations'][id$='excerpt']",
        ],
    ],
]);

Atcmobapp::translateModel('Atcmobapp/Nodes.Nodes', [
    'fields' => [
        'title',
        'excerpt',
        'body',
    ],
]);
