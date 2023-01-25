<?php

$this->setLayout('admin_login');

echo $this->Form->create($user);

    echo $this->Form->input('password', [
        'type' => 'password',
        'placeholder' => __d('atcmobile', 'New password'),
        'label' => false,
        'value' => '',
    ]);

    echo $this->Form->input('verify_password', [
        'type' => 'password',
        'placeholder' => __d('atcmobile', 'Verify Password'),
        'label' => false,
        'value' => '',
    ]);

    echo $this->Form->input(__d('atcmobile', 'Reset'), [
        'type' => 'submit',
        'class' => 'btn btn-primary',
        'templates' => [
            'submitContainer' => '<div class="float-right">{{content}}</div>',
        ],
    ]);

    echo $this->Form->end();
