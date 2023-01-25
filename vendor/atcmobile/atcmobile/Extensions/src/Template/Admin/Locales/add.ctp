<?php

$this->extend('/Common/admin_edit');

$this->Breadcrumbs->add(
    __d('atcmobile', 'Extensions'),
    ['plugin' => 'Atcmobapp/Extensions', 'controller' => 'Plugins', 'action' => 'index']
)
    ->add(
        __d('atcmobile', 'Locales'),
        ['plugin' => 'Atcmobapp/Extensions', 'controller' => 'Locales', 'action' => 'index']
    )
    ->add(__d('atcmobile', 'Upload'), $this->getRequest()->getRequestTarget());

$this->append('form-start', $this->Form->create(null, [
    'url' => [
        'plugin' => 'Atcmobapp/Extensions',
        'controller' => 'Locales',
        'action' => 'add',
    ],
    'type' => 'file',
]));

$this->append('tab-heading');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Upload'), '#locales-upload');
$this->end();

$this->append('tab-content');
echo $this->Html->tabStart('locales-upload') . $this->Form->input('Locale.file', [
        'type' => 'file',
        'class' => 'c-file'
    ]);
echo $this->Html->tabEnd();
$this->end();

$this->append('panels');
echo $this->Html->beginBox(__d('atcmobile', 'Publishing')) .
    '<div class="clearfix"><div class="float-left">' .
    $this->Form->button(__d('atcmobile', 'Upload'), ['button' => 'success']) .
    '</div><div class="float-right">' .
    $this->Html->link(__d('atcmobile', 'Cancel'), ['action' => 'index'], ['button' => 'danger']) .
    '</div></div>';
echo $this->Html->endBox();
$this->end();
