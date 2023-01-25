<?php

use Cake\Core\Configure;
use Atcmobapp\Core\Atcmobapp;

Configure::write(
    'DebugKit.panels',
    array_merge((array)Configure::read('DebugKit.panels'), [
        'Atcmobapp/Settings.Settings',
    ])
);

Atcmobapp::hookComponent('*', [
    'SettingsComponent' => [
        'className' => 'Atcmobapp/Settings.Settings'
    ]
]);
