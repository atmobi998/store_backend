<?php

use Cake\Core\Configure;
use Cake\Utility\Inflector;
use Atcmobapp\Core\Atcmobapp;

Atcmobapp::mergeConfig('Meta.keys', [
    // Uncomment if you need keywords.
    /*
    'meta_keywords' => [
        'label' => __d('seolite', 'Keywords'),
    ],
    */
    'meta_description' => [
        'label' => __d('atcmobile', 'Description'),
        'help' => __d('atcmobile', 'When empty, excerpt or first paragraph of body will be used'),
    ],
    'rel_canonical' => [
        'label' => __d('seolite', 'Canonical Page'),
        'type' => 'text',
        'help' => __d('atcmobile', 'When empty, value from Permalink will be used'),
    ],
]);

$title = 'SEO';
$element = 'Atcmobapp/Meta.admin/seo_tab';
Atcmobapp::hookAdminTab('Admin/Nodes/add', $title, $element);
Atcmobapp::hookAdminTab('Admin/Nodes/edit', $title, $element);

Atcmobapp::hookComponent('*', ['Atcmobapp/Meta.Meta' => ['priority' => 8]]);

Atcmobapp::hookHelper('*', 'Atcmobapp/Meta.Meta');

Inflector::rules('uninflected', ['meta']);
