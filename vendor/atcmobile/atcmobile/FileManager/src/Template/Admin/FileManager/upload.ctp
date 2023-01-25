<?php

$this->extend('Atcmobapp/Core./Common/admin_edit');

$this->Breadcrumbs->add(
    __d('atcmobile', 'File Manager'),
    ['plugin' => 'Atcmobapp/FileManager', 'controller' => 'FileManager', 'action' => 'browse']
)
    ->add(__d('atcmobile', 'Upload'), $this->getRequest()->getRequestTarget());

$this->start('page-heading');
echo $this->element('Atcmobapp/FileManager.admin/breadcrumbs');
$this->end();

$this->append('form-start', $this->Form->create(null, [
    'type' => 'file'
]));

$this->append('tab-heading');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Upload'), '#filemanager-upload');
$this->end();

$this->append('tab-content');
echo $this->Html->tabStart('filemanager-upload');
echo $this->Form->input('file', [
    'type' => 'file',
    'label' => '',
    'class' => 'file'
]);
echo $this->Html->tabEnd();

$this->end();

$this->append('panels');
echo $this->Html->beginBox(__d('atcmobile', 'Publishing'));
echo $this->element('Atcmobapp/Core.admin/buttons', [
    'saveText' => __d('atcmobile', 'Upload file'),
    'applyText' => false,
]);
echo $this->Html->endBox();

echo $this->Atcmobapp->adminBoxes();
$this->end();

$this->append('form-end', $this->Form->end());
