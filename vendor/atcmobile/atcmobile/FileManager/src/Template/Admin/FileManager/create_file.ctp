<?php

$this->assign('title', __d('atcmobile', 'Create File'));
$this->extend('Atcmobapp/Core./Common/admin_edit');

$this->Breadcrumbs->add(
    __d('atcmobile', 'File Manager'),
    ['plugin' => 'Atcmobapp/FileManager', 'controller' => 'FileManager', 'action' => 'browse']
)
    ->add(__d('atcmobile', 'Create File'), $this->getRequest()->getRequestTarget());

$this->start('page-heading');
echo $this->element('Atcmobapp/FileManager.admin/breadcrumbs');
$this->end();

$this->append('form-start', $this->Form->create(null));

$this->append('tab-heading');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'File'), '#filemanager-createfile');
$this->end();

$this->append('tab-content');
echo $this->Html->tabStart('filemanager-createfile');
echo $this->Form->input('name', [
        'type' => 'text',
        'label' => __d('atcmobile', 'Filename'),
        'prepend' => $path,
    ]);
echo $this->Form->input('content', [
    'type' => 'textarea',
    'label' => __d('atcmobile', 'Content')
]);
echo $this->Html->tabEnd();
$this->end();

$this->append('panels');
echo $this->Html->beginBox(__d('atcmobile', 'Publishing'));
echo $this->element('Atcmobapp/Core.admin/buttons', [
    'saveText' => __d('atcmobile', 'Create file'),
    'applyText' => false,
]);
echo $this->Html->endBox();
$this->end();
