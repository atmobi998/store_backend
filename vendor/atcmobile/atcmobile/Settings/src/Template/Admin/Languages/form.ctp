<?php

$this->extend('Atcmobapp/Core./Common/admin_edit');

$this->Breadcrumbs->add(
    __d('atcmobile', 'Settings'),
    ['plugin' => 'Atcmobapp/Settings', 'controller' => 'Settings', 'action' => 'prefix', 'Site']
)
    ->add(
        __d('atcmobile', 'Language'),
        ['plugin' => 'Atcmobapp/Settings', 'controller' => 'Languages', 'action' => 'index']
    );

if ($this->getRequest()->getParam('action') == 'edit') {
    $this->Breadcrumbs->add($language->title);
}

if ($this->getRequest()->getParam('action') == 'add') {
    $this->Breadcrumbs->add(__d('atcmobile', 'Add'), $this->getRequest()->getRequestTarget());
}

$this->append('form-start', $this->Form->create($language));

$this->start('tab-heading');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Language'), '#language-main');
$this->end();

$this->start('tab-content');
echo $this->Html->tabStart('language-main');
echo $this->Form->input('title', [
    'label' => __d('atcmobile', 'Title'),
]);
echo $this->Form->input('native', [
    'label' => __d('atcmobile', 'Native'),
]);
echo $this->Form->input('locale', [
    'label' => __d('atcmobile', 'Locale'),
]);
echo $this->Form->input('alias', [
    'label' => __d('atcmobile', 'Alias'),
    'help' => __d('atcmobile', 'Locale alias, typically a two letter country/locale code'),
]);
echo $this->Html->tabEnd();
$this->end();

$this->start('panels');
echo $this->Html->beginBox(__d('atcmobile', 'Publishing'));
echo $this->element('Atcmobapp/Core.admin/buttons', ['type' => 'language']);
echo $this->Form->input('status', [
    'label' => __d('atcmobile', 'Status'),
]);
echo $this->Html->endBox();
$this->end();
