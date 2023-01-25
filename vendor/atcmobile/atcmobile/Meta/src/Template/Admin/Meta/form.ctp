<?php

$this->extend('Atcmobapp/Core./Common/admin_edit');

$this->Breadcrumbs->add(__d('atcmobile', 'Settings'), ['plugin' => 'Atcmobapp/Settings', 'controller' => 'Settings', 'action' => 'index']);
$this->Breadcrumbs->add(__d('atcmobile', 'Meta'), ['action' => 'index']);

if ($this->getRequest()->getParam('action') == 'edit') {
    $this->Breadcrumbs->add(h($$viewVar->key), $this->getRequest()->getRequestTarget());

    $this->assign('title', __d('atcmobile', 'Edit Meta'));
}

if ($this->getRequest()->getParam('action') == 'add') {
    $this->Breadcrumbs->add(__d('atcmobile', 'Add'), $this->getRequest()->getRequestTarget());

    $this->assign('title', __d('atcmobile', 'Add Meta'));
}
