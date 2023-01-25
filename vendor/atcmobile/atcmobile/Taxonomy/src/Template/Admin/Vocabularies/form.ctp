<?php
$this->Atcmobapp->adminScript('Atcmobapp/Taxonomy.vocabularies');

$this->extend('Atcmobapp/Core./Common/admin_edit');

$this->Breadcrumbs->add(
    __d('atcmobile', 'Content'),
    ['plugin' => 'Atcmobapp/Nodes', 'controller' => 'Nodes', 'action' => 'index']
);

if ($this->getRequest()->getParam('action') == 'edit') {
    $this->assign('title', __d('atcmobile', 'Edit Vocabulary'));

    $this->Breadcrumbs->add(__d('atcmobile', 'Vocabularies'), ['action' => 'index', $vocabulary->id])
        ->add($vocabulary->title);
}

if ($this->getRequest()->getParam('action') == 'add') {
    $this->assign('title', __d('atcmobile', 'Add Vocabulary'));

    $this->Breadcrumbs->add(__d('atcmobile', 'Vocabularies'), ['action' => 'index'])
        ->add(__d('atcmobile', 'Add'), $this->getRequest()->getRequestTarget());
}

$this->append('form-start', $this->Form->create($vocabulary, [
    'class' => 'protected-form',
]));

$this->start('tab-heading');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Vocabulary'), '#vocabulary-basic');
$this->end();

$this->start('tab-content');
echo $this->Html->tabStart('vocabulary-basic');
echo $this->Form->input('title', [
    'label' => __d('atcmobile', 'Title'),
    'data-slug' => '#alias',
]);
echo $this->Form->input('alias', [
    'label' => __d('atcmobile', 'Alias'),
    'class' => 'slug',
]);
echo $this->Form->input('description', [
    'label' => __d('atcmobile', 'Description'),
]);
echo $this->Form->input('types._ids', [
    'label' => __d('atcmobile', 'Content types'),
    'class' => 'c-select',
    'help' => __d('atcmobile', 'Select which content types will use this vocabulary')
]);
echo $this->Html->tabEnd();
$this->end();

$this->start('panels');
echo $this->Html->beginBox();
echo $this->element('Atcmobapp/Core.admin/buttons', ['type' => __d('atcmobile', 'vocabulary')]);
echo $this->Html->endBox();

echo $this->Html->beginBox(__d('atcmobile', 'Options'));
echo $this->Form->input('required', [
    'label' => __d('atcmobile', 'Required'),
    'class' => false,
    'help' => __d('atcmobile', 'Required to select a term from the vocabulary.'),
]);
echo $this->Form->input('multiple', [
    'label' => __d('atcmobile', 'Multiple selections'),
    'class' => false,
    'help' => __d('atcmobile', 'Allow multiple terms to be selected.'),
]);
echo $this->Form->input('tags', [
    'label' => __d('atcmobile', 'Freetags'),
    'class' => false,
    'help' => __d('atcmobile', 'Allow free-typing of terms/tags.'),
]);
echo $this->Html->endBox();
$this->end();
