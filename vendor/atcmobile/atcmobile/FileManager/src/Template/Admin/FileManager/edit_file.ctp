<?php

$this->assign('title', __d('atcmobile', 'Edit file: %s', $path));

$this->extend('Atcmobapp/Core./Common/admin_edit');

$this->Breadcrumbs->add(
    __d('atcmobile', 'File Manager'),
    ['plugin' => 'Atcmobapp/FileManager', 'controller' => 'FileManager', 'action' => 'browse']
)
    ->add(basename($absolutefilepath), $this->getRequest()->getRequestTarget());

$this->start('page-heading');
echo $this->element('Atcmobapp/FileManager.admin/breadcrumbs');
$this->end();

$this->append('form-start', $this->Form->create(null));

$this->append('tab-heading');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Edit'), '#filemanager-edit');
$this->end();

$this->append('tab-content');
echo $this->Html->tabStart('filemanager-edit') . $this->Form->input('content', [
        'type' => 'textarea',
        'value' => $content,
        'label' => false,
    ]);
echo $this->Html->tabEnd();
$this->end();

$this->append('panels');
echo $this->Html->beginBox(__d('atcmobile', 'Publishing'));
echo $this->element('Atcmobapp/Core.admin/buttons', [
    'applyText' => false,
]);
echo $this->Html->endBox();
$this->end();
