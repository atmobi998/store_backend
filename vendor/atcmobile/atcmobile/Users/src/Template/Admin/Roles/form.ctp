<?php
$this->extend('Atcmobapp/Core./Common/admin_edit');
$this->Breadcrumbs
    ->add(__d('atcmobile', 'Users'), ['plugin' => 'Atcmobapp/Users', 'controller' => 'Users', 'action' => 'index'])
    ->add(__d('atcmobile', 'Roles'), ['plugin' => 'Atcmobapp/Users', 'controller' => 'Roles', 'action' => 'index']);

if ($this->getRequest()->getParam('action') == 'edit') {
    $this->Breadcrumbs->add(h($role->title), $this->getRequest()->getRequestTarget());
}

if ($this->getRequest()->getParam('action') == 'add') {
    $this->Breadcrumbs->add(__d('atcmobile', 'Add'), $this->getRequest()->getRequestTarget());
}

$this->assign('form-start', $this->Form->create($role));

$this->start('tab-heading');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Role'), '#role-main');
$this->end();

$this->start('tab-content');
echo $this->Html->tabStart('role-main');
echo $this->Form->input('title', [
    'label' => __d('atcmobile', 'Title'),
    'data-slug' => '#alias'
]);
echo $this->Form->input('alias', [
    'label' => __d('atcmobile', 'Alias'),
]);
echo $this->Html->tabEnd();
$this->end();
