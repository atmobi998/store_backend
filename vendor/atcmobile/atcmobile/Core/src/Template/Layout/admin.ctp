<?php
$showActions = isset($showActions) ? $showActions : true;
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title><?= $this->fetch('title') ?> - <?= $_siteTitle ?></title>
        <?php

        echo $this->element('admin/stylesheets');
        echo $this->element('admin/javascripts');

        echo $this->fetch('script');
        echo $this->fetch('css');

        ?>
    </head>
    <body>
        <?= $this->element('Atcmobapp/Core.admin/header') ?>
        <div id="wrap">
            <div class="nav-sidebar">
                <?= $this->element('Atcmobapp/Core.admin/navigation') ?>
            </div>
            <div id="content-container" class="content-container <?= $this->Theme->getCssClass('containerFluid') ?>">
                <div id="content" class="content">
                    <div id="breadcrumb-container" class="col-12 p-0 d-flex justify-content-between align-items-center">
                        <?= $this->element('Atcmobapp/Core.admin/breadcrumb') ?>
                        <?php if ($showActions && $actionsBlock = $this->fetch('action-buttons')) : ?>
                            <div class="actions m-2 ml-auto">
                                <?= $actionsBlock ?>
                            </div>
                        <?php endif ?>
                    </div>
                    <div id="inner-content" class="p-0 mt-2 <?= $this->Theme->getCssClass('columnFull') ?>">
                        <?= $this->Layout->sessionFlash() ?>
                        <?= $this->fetch('content') ?>
                    </div>
                </div>
            </div>
        </div>
        <?= $this->element('Atcmobapp/Core.admin/footer') ?>
        <?php
        echo $this->element('Atcmobapp/Core.admin/initializers');
        echo $this->fetch('body-footer');

        echo $this->fetch('postLink');
        echo $this->fetch('scriptBottom');
        echo $this->Js->writeBuffer();
        ?>
    </body>
</html>