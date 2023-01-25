<?php

if (!$this->getRequest()->is('ajax')) :
    echo $this->Layout->js();
    echo $this->Html->script([
        'Atcmobapp/Core.jquery/jquery.min.js',
        'Atcmobapp/Core.core/moment-with-locales',
        'Atcmobapp/Core.core/underscore-min',
    ]);
    echo $this->Html->script([
        'Atcmobapp/Core.jquery/jquery-ui.min.js',
        'Atcmobapp/Core.core/popper.min.js',
        'Atcmobapp/Core.core/bootstrap.min.js',
        '//cdn.jsdelivr.net/npm/transliteration@2.1.8/dist/browser/bundle.umd.min.js',
        'Atcmobapp/Core.jquery/jquery.slug',
        'Atcmobapp/Core.jquery/jquery.hoverIntent.minified',
        'Atcmobapp/Core.core/bootstrap3-typeahead.min',
        'Atcmobapp/Core.core/moment-timezone-with-data',
        'Atcmobapp/Core.core/tempusdominus-bootstrap-4.min',
        'Atcmobapp/Core.core/typeahead_autocomplete',
        'Atcmobapp/Core.core/ekko-lightbox.min.js',
        'Atcmobapp/Core.core/select2.full.min.js',
        'Atcmobapp/Core.core/sidebar',
        'Atcmobapp/Core.core/choose',
        'Atcmobapp/Core.core/modal',
    ], [
        'async' => true,
    ]);
    echo $this->Html->script([
        'Atcmobapp/Core.core/admin',
    ], [
        'defer' => true,
    ]);
endif;
