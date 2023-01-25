<p>
<?= __d('atcmobapp', 'Hello %s', $user->name); ?>,
</p>

<p>
<?php
    $url = $this->Url->build([
        'plugin' => 'Atcmobapp/Mobapps',
        'controller' => 'Profiles',
        'action' => 'reset',
        $user->username,
        $user->activation_key,
    ], true);
    echo __d('atcmobapp', 'Please visit this link to reset your password: %s', $url);
    ?>
</p>

<p>
    <?= __d('atcmobapp', 'If you did not request a password reset, then please ignore this email.'); ?>
</p>

<p>
    <?= __d('atcmobapp', 'IP Address: %s', $_SERVER['REMOTE_ADDR']); ?>
</p>
