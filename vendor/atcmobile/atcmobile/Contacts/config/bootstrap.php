<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Atcmobapp\Core\Atcmobapp;
use Atcmobapp\Wysiwyg\Wysiwyg;

Cache::setConfig('contacts_view', array_merge(
    Configure::read('Atcmobapp.Cache.defaultConfig'),
    ['groups' => ['contacts']]
));

Atcmobapp::translateModel('Atcmobapp/Contacts.Contacts', [
    'fields' => [
        'title',
        'body',
    ],
]);

// Configure Wysiwyg
Wysiwyg::setActions([
    'Atcmobapp/Contacts.Admin/Contacts/add' => [
        [
            'elements' => '#body',
        ],
    ],
    'Atcmobapp/Contacts.Admin/Contacts/edit' => [
        [
            'elements' => '#body',
        ],
    ],
]);
