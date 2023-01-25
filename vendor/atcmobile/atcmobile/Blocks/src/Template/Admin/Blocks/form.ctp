<?php

$this->extend('Atcmobapp/Core./Common/admin_edit');

$this->Breadcrumbs->add(__d('atcmobile', 'Blocks'), ['action' => 'index']);

if ($this->getRequest()->getParam('action') == 'edit') {
    $this->Breadcrumbs->add(h($block->title), $this->getRequest()->getRequestTarget());
}
if ($this->getRequest()->getParam('action') == 'add') {
    $this->Breadcrumbs->add(__d('atcmobile', 'Add'), $this->getRequest()->getRequestTarget());
}

$this->append('form-start', $this->Form->create($block, [
    'class' => 'protected-form',
]));

$this->append('tab-heading');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Block'), '#block-basic');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Visibilities'), '#block-visibilities');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Params'), '#block-params');
$this->end();

$this->append('tab-content');

echo $this->Html->tabStart('block-basic') . $this->Form->input('title', [
        'label' => __d('atcmobile', 'Title'),
        'data-slug' => '#alias',
    ]) . $this->Form->input('alias', [
        'label' => __d('atcmobile', 'Alias'),
        'help' => __d('atcmobile', 'unique name for your block'),
    ]) . $this->Form->input('region_id', [
        'label' => __d('atcmobile', 'Region'),
        'help' => __d('atcmobile', 'if you are not sure, choose \'none\''),
        'class' => 'c-select',
    ]) . $this->Form->input('body', [
        'label' => __d('atcmobile', 'Body'),
    ]) . $this->Form->input('class', [
        'label' => __d('atcmobile', 'Class'),
    ]) . $this->Form->input('element', [
        'label' => __d('atcmobile', 'Element'),
    ]) . $this->Form->input('cell', [
        'label' => __d('atcmobile', 'Cell'),
    ]);
echo $this->Html->tabEnd();

echo $this->Html->tabStart('block-visibilities') . $this->Form->input('visibility_paths', [
        'type' => 'stringlist',
        'label' => __d('atcmobile', 'Visibility Paths'),
        'help' => __d('atcmobile', 'Enter one URL per line. Leave blank if you want this Block to appear in all pages.'),
    ]);
echo $this->Html->tabEnd();

echo $this->Html->tabStart('block-params') . $this->Form->input('params', [
        'type' => 'stringlist',
        'label' => __d('atcmobile', 'Params'),
    ]);
echo $this->Html->tabEnd();

$this->end();

$this->append('panels');
echo $this->Html->beginBox(__d('atcmobile', 'Publishing'));
echo $this->element('Atcmobapp/Core.admin/buttons', ['type' => 'block']);
echo $this->element('Atcmobapp/Core.admin/publishable');
echo $this->Form->input('show_title', [
    'label' => __d('atcmobile', 'Show title ?'),
]);
echo $this->Html->endBox();

echo $this->Html->beginBox(__d('atcmobile', 'Access control'));
echo $this->Form->input('visibility_roles', [
    'class' => 'c-select',
    'options' => $roles,
    'multiple' => true,
    'label' => false,
]);
echo $this->Html->endBox();

echo $this->Atcmobapp->adminBoxes();
$this->end();
