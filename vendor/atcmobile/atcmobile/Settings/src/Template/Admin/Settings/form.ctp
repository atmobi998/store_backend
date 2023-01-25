<?php
$this->extend('Atcmobapp/Core./Common/admin_edit');

$this->Breadcrumbs
    ->add(__d('atcmobile', 'Settings'), [
        'plugin' => 'Atcmobapp/Settings',
        'controller' => 'Settings',
        'action' => 'index',
    ]);

if ($this->getRequest()->getParam('action') == 'edit') {
    $this->Breadcrumbs->add(h($setting->key), $this->getRequest()->getRequestTarget());
}

if ($this->getRequest()->getParam('action') == 'add') {
    $this->Breadcrumbs->add(__d('atcmobile', 'Add'), $this->getRequest()->getRequestTarget());
}

$this->append('form-start', $this->Form->create($setting, [
    'class' => 'protected-form',
]));

$this->start('tab-heading');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Settings'), '#setting-basic');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Misc'), '#setting-misc');
$this->end();

$this->start('tab-content');
echo $this->Html->tabStart('setting-basic') . $this->Form->input('key', [
        'help' => __d('atcmobile', "e.g., 'Site.title'"),
        'label' => __d('atcmobile', 'Key'),
    ]) . $this->Form->input('value', [
        'label' => __d('atcmobile', 'Value'),
    ]) . $this->Html->tabEnd();

echo $this->Html->tabStart('setting-misc') . $this->Form->input('title', [
        'label' => __d('atcmobile', 'Title'),
    ]) . $this->Form->input('description', [
        'label' => __d('atcmobile', 'Description'),
    ]) . $this->Form->input('input_type', [
        'label' => __d('atcmobile', 'Input Type'),
        'help' => __d('atcmobile', "e.g., 'text' or 'textarea'"),
    ]) . $this->Form->input('editable', [
        'label' => __d('atcmobile', 'Editable'),
    ]) . $this->Form->input('params', [
        'label' => __d('atcmobile', 'Params'),
    ]) . $this->Html->tabEnd();

    $this->end();
