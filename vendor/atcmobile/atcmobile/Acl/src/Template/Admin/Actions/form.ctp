<?php
$this->extend('Atcmobapp/Core./Common/admin_edit');

$this->Breadcrumbs
    ->add(__d('atcmobile', 'Users'), ['plugin' => 'Atcmobapp/Users', 'controller' => 'Users', 'action' => 'index'])
    ->add(__d('atcmobile', 'Permissions'), ['plugin' => 'Atcmobapp/Acl', 'controller' => 'Permissions'])
    ->add(__d('atcmobile', 'Actions'), ['plugin' => 'Atcmobapp/Acl', 'controller' => 'Actions', 'action' => 'index']);

if ($this->getRequest()->getParam('action') == 'edit') {
    $this->Breadcrumbs->add($aco->id . ': ' . $aco->alias, $this->getRequest()->getRequestTarget());
}

if ($this->getRequest()->getParam('action') == 'add') {
    $this->Breadcrumbs->add(__d('atcmobile', 'Add'), $this->getRequest()->getRequestTarget());
}

$this->assign('form-start', $this->Form->create($aco));

$this->append('tab-heading');
    echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Action'), '#action-main');
$this->end();

$this->append('tab-content');

    echo $this->Form->input('parent_id', [
        'options' => $acos,
        'empty' => true,
        'label' => __d('atcmobile', 'Parent'),
    ]);
    $this->Form->templates([
        'class' => 'span10',
    ]);
    echo $this->Form->input('alias', [
        'label' => __d('atcmobile', 'Alias'),
    ]);

    $this->end();
