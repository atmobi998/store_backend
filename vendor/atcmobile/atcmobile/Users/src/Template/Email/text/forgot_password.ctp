<?php

echo __d('atcmobile', 'Hello %s', $user->name) ?>,


<?php
    $url = $this->Url->build([
        'plugin' => 'Atcmobapp/Users',
        'controller' => 'Users',
        'action' => 'reset',
        $user->username,
        $user->activation_key,
    ], true);
    echo __d('atcmobile', 'Please visit this link to reset your password: %s', $url);
    ?>


<?= __d('atcmobile', 'If you did not request a password reset, then please ignore this email.') ?>


<?= __d('atcmobile', 'IP Address: %s', $_SERVER['REMOTE_ADDR']) ?>
