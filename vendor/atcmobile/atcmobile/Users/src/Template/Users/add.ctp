<?php

$this->assign('title', __d('atcmobile', 'Registration'));

?>
<div class="users form">
    <h2><?= $this->fetch('title') ?></h2>
    <?= $this->Form->create('User') ?>
        <fieldset>
        <?php
            echo $this->Form->input('username');
            echo $this->Form->input('password', ['value' => '']);
            echo $this->Form->input('verify_password', ['type' => 'password', 'value' => '']);
            echo $this->Form->input('name');
            echo $this->Form->input('email');
            echo $this->Form->input('website');

            echo $this->Form->submit(__d('atcmobile', 'Register'));
        ?>
        </fieldset>
    <?= $this->Form->end() ?>
</div>