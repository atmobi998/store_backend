<?php

use Cake\Core\Configure;

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title><?= $this->fetch('title') ?> - <?= $_siteTitle ?></title>
        <?php
        echo $this->Html->css([
            'Atcmobapp/Core.core/atcmobile-admin',
        ]);
        echo $this->Layout->js();
        echo $this->Html->script([]);

        echo $this->fetch('script');
        echo $this->fetch('css');
        ?>
    </head>
    <body class="admin-login">
        <header class="navbar navbar-dark bg-black">
            <?= $this->Html->link(__d('atcmobile', 'Back to') . ' ' . Configure::read('Site.title'), '/', ['class' => 'navbar-brand']) ?>
        </header>

        <div id="wrap" class="d-flex justify-content-center align-items-center">
            <?= $this->fetch('content') ?>
        </div>
        <?= $this->element('Atcmobapp/Core.admin/footer') ?>
    </body>
</html>
