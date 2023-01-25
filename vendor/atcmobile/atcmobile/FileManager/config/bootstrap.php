<?php

use Cake\Core\Configure;
use Atcmobapp\Core\Atcmobapp;
use Atcmobapp\FileManager\Utility\StorageManager;
use Atcmobapp\Wysiwyg\Wysiwyg;

Configure::write('Wysiwyg.attachmentBrowseUrl', [
    'prefix' => 'admin',
    'plugin' => 'Atcmobapp/FileManager',
    'controller' => 'Attachments',
    'action' => 'browse',
]);

Wysiwyg::setActions([
    'Atcmobapp/FileManager.Admin/Attachments/browse' => [],
]);

Configure::write('FileManager', [
    'editablePaths' => [
        WWW_ROOT . 'assets',
    ],
    'deletablePaths' => [
        WWW_ROOT . 'assets',
    ],
]);

StorageManager::config('LocalAttachment', [
    'description' => 'Local Attachment',
    'adapterOptions' => [WWW_ROOT . 'assets', true],
    'adapterClass' => '\League\Flysystem\Adapter\Local',
    'class' => '\League\Flysystem\Filesystem',
]);
StorageManager::config('LegacyLocalAttachment', [
    'description' => 'Local Attachment (Legacy)',
    'adapterOptions' => [WWW_ROOT . 'uploads', true],
    'adapterClass' => '\League\Flysystem\Adapter\Local',
    'class' => '\League\Flysystem\Filesystem',
]);

// TODO: make this configurable via backend
$actions = [
    'Admin/Blocks/edit',
    'Admin/Contacts/edit',
    'Admin/Links/edit',
    'Admin/Nodes/edit',
    'Admin/Terms/edit',
    'Admin/Types/edit',
    'Admin/Vocabularies/edit',
];
$tabTitle = __d('atcmobile', 'Media');
foreach ($actions as $action) :
    list($controller, ) = explode('/', $action);
    Atcmobapp::hookAdminTab($action, $tabTitle, 'Atcmobapp/FileManager.admin/asset_list');
    Atcmobapp::hookHelper($controller, 'Atcmobapp/FileManager.AssetsAdmin');
endforeach;

// TODO: make this configurable via backend
$models = [
    'Atcmobapp/Blocks.Blocks',
    'Atcmobapp/Contacts.Contacts',
    'Atcmobapp/Menus.Links',
    'Atcmobapp/Nodes.Nodes',
    'Atcmobapp/Taxonomy.Terms',
    'Atcmobapp/Taxonomy.Types',
    'Atcmobapp/Taxonomy.Vocabularies',
];
foreach ($models as $model) {
    Atcmobapp::hookBehavior($model, 'Atcmobapp/FileManager.LinkedAssets', ['priority' => 9]);
}

Atcmobapp::hookHelper('*', 'Atcmobapp/FileManager.AssetsFilter');
