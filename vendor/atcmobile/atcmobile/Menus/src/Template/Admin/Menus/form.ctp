<?php

$this->extend('Atcmobapp/Core./Common/admin_edit');
$this->Atcmobapp->adminScript('Atcmobapp/Menus.admin');

$this->Breadcrumbs->add(__d('atcmobile', 'Menus'), ['action' => 'index']);

if ($this->getRequest()->getParam('action') == 'edit') {
    $this->Breadcrumbs->add(h($menu->title), $this->getRequest()->getRequestTarget());

    $this->assign('title', __d('atcmobile', 'Edit Menu'));
}

if ($this->getRequest()->getParam('action') == 'add') {
    $this->Breadcrumbs->add(__d('atcmobile', 'Add'), $this->getRequest()->getRequestTarget());

    $this->assign('title', __d('atcmobile', 'Add Menu'));
}

$this->append('form-start', $this->Form->create($menu));

$this->append('tab-heading');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Menu'), '#menu-basic');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Misc.'), '#menu-misc');
$this->end();

$this->append('tab-content');
echo $this->Html->tabStart('menu-basic');
echo $this->Form->input('title', [
    'label' => __d('atcmobile', 'Title'),
    'data-slug' => '#alias'
]);
echo $this->Form->input('alias', [
    'label' => __d('atcmobile', 'Alias'),
]);
echo $this->Form->input('description', [
    'label' => __d('atcmobile', 'Description'),
]);
echo $this->Html->tabEnd();
$this->end();

$this->append('tab-content');
echo $this->Html->tabStart('menu-misc');
echo $this->Form->input('params', [
    'label' => __d('atcmobile', 'Params'),
    'type' => 'stringlist',
]);
echo $this->Form->input('class');
echo $this->Html->tabEnd();

$this->end();

$this->start('panels');
echo $this->Html->beginBox('Publishing');
echo $this->element('Atcmobapp/Core.admin/buttons', ['type' => 'menu']);
echo $this->element('Atcmobapp/Core.admin/publishable');
echo $this->Html->endBox();
$this->end();
