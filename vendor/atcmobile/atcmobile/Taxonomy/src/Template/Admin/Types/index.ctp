<?php
$this->Breadcrumbs->add(
    __d('atcmobile', 'Content'),
    ['plugin' => 'Atcmobapp/Nodes', 'controller' => 'Nodes', 'action' => 'index']
)
    ->add(__d('atcmobile', 'Types'), $this->getRequest()->getRequestTarget());

$this->extend('Atcmobapp/Core./Common/admin_index');
