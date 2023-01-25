<?php
$this->extend('Atcmobapp/Core./Common/admin_index');
$this->Breadcrumbs->add(__d('atcmobile', 'Contacts'), $this->getRequest()->getUri()->getPath());
