<?php

$this->assign('title', __d('atcmobile', 'Create Directory'));
$this->extend('Atcmobapp/Core./Common/admin_edit');

$this->Breadcrumbs->add(
    __d('atcmobile', 'File Manager'),
    ['plugin' => 'Atcmobapp/FileManager', 'controller' => 'FileManager', 'action' => 'browse']
)
    ->add(__d('atcmobile', 'Create Directory'), $this->getRequest()->getRequestTarget());

$this->append('form-start', $this->Form->create(null));

$this->start('page-heading');
echo $this->element('Atcmobapp/FileManager.admin/breadcrumbs');
$this->end();

$this->start('tab-heading');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Directory'), '#filemanager-createdir');
$this->end();

$this->append('tab-content');
echo $this->Html->tabStart('filemanager-createdir') . $this->Form->input('name', [
        'type' => 'text',
        'label' => __d('atcmobile', 'Directory name'),
        'prepend' => $path,
    ]);
echo $this->Html->tabEnd();
$this->end();

$this->start('panels');
echo $this->Html->beginBox(__d('atcmobile', 'Publishing'));
echo $this->element('Atcmobapp/Core.admin/buttons', [
    'saveText' => __d('atcmobile', 'Create directory'),
    'applyText' => false,
]);
echo $this->Html->endBox();

echo $this->Atcmobapp->adminBoxes();
$this->end();
