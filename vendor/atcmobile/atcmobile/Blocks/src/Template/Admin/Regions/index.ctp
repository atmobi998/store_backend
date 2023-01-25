<?php
$this->extend('Atcmobapp/Core./Common/admin_index');
$this->Breadcrumbs->add(__d('atcmobile', 'Blocks'), ['controller' => 'Blocks', 'action' => 'index'])
    ->add(__d('atcmobile', 'Regions'), $this->getRequest()->getUri()->getPath());
?>
