<?php

use Cake\Core\Configure;

$this->assign('title', __d('atcmobile', 'Login'));

$formStart = $this->Form->create(false, ['url' => ['action' => 'login']]);
$body = $this->Form->input('username', [
    'placeholder' => __d('atcmobile', 'Username'),
    'label' => false,
    'prepend' => $this->Html->icon('user', ['class' => 'fa-fw']),
    'required' => true,
]);
$body .= $this->Form->input('password', [
    'placeholder' => __d('atcmobile', 'Password'),
    'label' => false,
    'prepend' => $this->Html->icon('key', ['class' => 'fa-fw']),
    'required' => true,
]);
if (Configure::read('Access Control.autoLoginDuration')) :
    $body .= $this->Form->input('remember', [
        'label' => __d('atcmobile', 'Remember me?'),
        'type' => 'checkbox',
        'default' => false,
    ]);
endif;

$footer = $this->Html->link(__d('atcmobile', 'Forgot password?'), [
    'prefix' => 'admin',
    'plugin' => 'Atcmobapp/Users',
    'controller' => 'Users',
    'action' => 'forgot',
], [
    'class' => 'forgot',
]);
$footer .= $this->Form->button(__d('atcmobile', 'Log In'), ['class' => 'btn btn-primary']);
$formEnd = $this->Form->end();

?>
<div class="card rounded-plus bg-faded">
    <div class="card-header">
        <h5 class="card-title"><?= $this->fetch('title') ?></h5>
    </div>
    <?= $formStart ?>
    <div class="card-body">
        <?php
        echo $this->Layout->sessionFlash();
        echo $body;
        ?>
    </div>
    <div class="card-footer text-right">
        <?= $footer ?>
    </div>
    <?= $formEnd ?>
</div>
