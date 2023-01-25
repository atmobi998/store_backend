<?php

use Cake\Core\Configure;

Configure::write('Wysiwyg.attachmentBrowseUrl', [
    'prefix' => 'admin',
    'plugin' => 'Atcmobapp/FileManager',
    'controller' => 'Attachments',
    'action' => 'browse',
    '?' => [
        'editor' => true,
    ]
]);
