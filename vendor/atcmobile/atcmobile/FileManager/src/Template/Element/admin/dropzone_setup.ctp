<?php
/**
 * @var \uAfrica\View\AppView $this
 */

echo $this->Html->tag(
    'div',
    $this->Html->tag('p', __d('atcmobile', 'Drop files here to upload')),
    [
        'id' => 'dropzone-target',
        'data-base-url' => $this->Url->build('/', true),
        'data-csrf-token' => $this->getRequest()->getParam('_csrfToken'),
        'data-url' => $this->Url->build([
            'action' => 'add',
            'prefix' => 'admin',
            'controller' => 'Attachments',
            'plugin' => 'Atcmobapp/FileManager'
        ], true),
    ]
);
echo $this->Html->tag(
    'script',
    $this->element('Atcmobapp/FileManager.admin/dropzone_' . $type . '_preview'),
    ['id' => 'dropzone-preview', 'type' => 'text/html']
);
$this->Form->create(null, [
    'url' => [
        'action' => 'add',
        'prefix' => 'admin',
        'controller' => 'Attachments',
        'plugin' => 'Atcmobapp/FileManager'
    ],
]);
$this->Form->unlockField('file');
echo $this->Html->tag('div', $this->Form->secure([]), ['id' => 'tokens']);
$this->Form->end();
