<?php

$this->extend('Atcmobapp/Core./Common/admin_index');

$this->Breadcrumbs->add(__d('atcmobile', 'Users'), $this->getRequest()->getUri()->getPath());
