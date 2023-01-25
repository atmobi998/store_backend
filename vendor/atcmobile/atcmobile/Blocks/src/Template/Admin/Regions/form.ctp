<?php

$this->extend('Atcmobapp/Core./Common/admin_edit');

$this->Breadcrumbs->add(__d('atcmobile', 'Blocks'), [
        'controller' => 'Blocks',
        'action' => 'index',
    ])
    ->add(__d('atcmobile', 'Regions'), [
        'controller' => 'Regions',
        'action' => 'index',
    ]);

if ($this->getRequest()->getParam('action ')== 'edit') {
    $this->Breadcrumbs->add(h($region->title), $this->getRequest()->getRequestTarget());
}

if ($this->getRequest()->getParam('action') == 'add') {
    $this->Breadcrumbs->add(__d('atcmobile', 'Add'), $this->getRequest()->getRequestTarget());
}

$this->append('form-start', $this->Form->create($region));

$this->append('tab-heading');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Region'), '#region-main');
$this->end();

$this->append('tab-content');

echo $this->Html->tabStart('region-main') . $this->Form->input('title', [
        'label' => __d('atcmobile', 'Title'),
        'data-slug' => '#alias'
    ]) . $this->Form->input('alias', [
        'label' => __d('atcmobile', 'Alias'),
    ]);
echo $this->Html->tabEnd();
$this->end();
