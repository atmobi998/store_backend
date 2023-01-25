<?php

if (!$this->getRequest()->is('ajax')) :
    echo $this->Html->css([
        'Atcmobapp/Core.core/atcmobile-admin',
        'Atcmobapp/Core.core/tempusdominus-bootstrap-4.min',
        'Atcmobapp/Core.core/typeaheadjs',
        'Atcmobapp/Core.core/ekko-lightbox.min.css',
        'Atcmobapp/Core.core/select2.min.css',
        'Atcmobapp/Core.core/select2-bootstrap.min.css',
        'Atcmobapp/Core.core/custom.css',
    ]);
endif;
