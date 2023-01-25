<?php
$this->extend('Atcmobapp/Core./Common/admin_index');

$this->Breadcrumbs
    ->add(__d('atcmobile', 'Users'), ['plugin' => 'Atcmobapp/Users', 'controller' => 'Users', 'action' => 'index'])
    ->add(__d('atcmobile', 'Roles'), $this->getRequest()->getUri()->getPath());
