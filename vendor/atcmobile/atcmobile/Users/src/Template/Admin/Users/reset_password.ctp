<?php
$this->extend('Atcmobapp/Core./Common/admin_edit');

$this->assign('title', __d('atcmobile', 'Reset password: %s', $user->username));
$this->Breadcrumbs
    ->add(__d('atcmobile', 'Users'), ['plugin' => 'Atcmobapp/Users', 'controller' => 'Users', 'action' => 'index'])
    ->add($user->name, [
        'action' => 'edit',
        $user->id,
    ])
    ->add(__d('atcmobile', 'Reset Password'), $this->getRequest()->getRequestTarget());
$this->assign('form-start', $this->Form->create($user));

$this->start('tab-heading');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Reset Password'), '#reset-password');
$this->end();

$this->start('tab-content');
echo $this->Html->tabStart('reset-password');
echo $this->Form->input('password', ['label' => __d('atcmobile', 'New Password'), 'value' => '']);
echo $this->Form->input(
    'verify_password',
    ['label' => __d('atcmobile', 'Verify Password'), 'type' => 'password', 'value' => '']
);
echo $this->Html->tabEnd();
$this->end();
