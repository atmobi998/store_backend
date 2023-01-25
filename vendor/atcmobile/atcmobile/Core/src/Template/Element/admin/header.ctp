<?php

use Cake\Core\Configure;
use Atcmobapp\Core\Nav;
use Atcmobapp\Core\Utility\StringConverter;

$dashboardUrl = (new StringConverter())->linkStringToArray(
    Configure::read('Site.dashboard_url')
);

?>
<header class="navbar navbar-expand-md navbar-dark bg-black fixed-top">
    <?= $this->Html->link(
    Configure::read('Site.title'),
    $dashboardUrl,
    ['class' => 'navbar-brand']
); ?>

    <?= $this->Atcmobapp->adminMenus(Nav::items('top-left'), [
        'type' => 'dropdown',
        'htmlAttributes' => [
            'id' => 'top-left-menu',
            'class' => 'navbar-nav d-none d-sm-block mr-auto',
        ],
    ]);
?>
    <?php if ($this->getRequest()->getSession()->read('Auth.User.id')) : ?>
        <?php
        echo $this->Atcmobapp->adminMenus(Nav::items('top-right'), [
            'type' => 'dropdown',
            'htmlAttributes' => [
                'id' => 'top-right-menu',
                'class' => 'navbar-nav ml-auto',
            ],
        ]);
        ?>
    <?php endif; ?>
</header>
