<?php

$this->extend('Atcmobapp/Core./Common/admin_index');

$this->Breadcrumbs->add(__d('atcmobile', 'Settings'), ['plugin' => 'Atcmobapp/Settings', 'controller' => 'Settings', 'action' => 'index']);
$this->Breadcrumbs->add(__d('atcmobile', 'Meta'), $this->getRequest()->getUri()->getPath());
