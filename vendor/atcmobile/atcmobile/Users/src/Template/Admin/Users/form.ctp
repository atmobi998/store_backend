<?php
$this->Html->script('Atcmobapp/Users.admin', ['block' => true]);

use Cake\I18n\Time;

$this->extend('Atcmobapp/Core./Common/admin_edit');

$this->Breadcrumbs->add(
    __d('atcmobile', 'Users'),
    ['plugin' => 'Atcmobapp/Users', 'controller' => 'Users', 'action' => 'index']
);

if ($this->getRequest()->getParam('action') == 'edit') {
    $this->Breadcrumbs->add(h($user->name), $this->getRequest()->getRequestTarget());
    $this->assign('title', __d('atcmobile', 'Edit user %s', $user->username));
} else {
    $this->assign('title', __d('atcmobile', 'New user'));
    $this->Breadcrumbs->add(__d('atcmobile', 'New user'), $this->getRequest()->getRequestTarget());
}

$this->start('action-buttons');
if ($this->getRequest()->getParam('action') == 'edit') :
    echo $this->Atcmobapp->adminAction(__d('atcmobile', 'Reset password'), ['action' => 'reset_password', $user->id]);
endif;
$this->end();

$this->append('form-start', $this->Form->create($user, [
    'fieldAccess' => [
        'User.role_id' => 1,
    ],
    'class' => 'protected-form',
]));

$this->append('tab-heading');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'User'), '#user-main');
$this->end();

$this->append('tab-content');

echo $this->Html->tabStart('user-main');
echo $this->Form->input('username', [
    'label' => __d('atcmobile', 'Username'),
]);
echo $this->Form->input('name', [
    'label' => __d('atcmobile', 'Name'),
]);
echo $this->Form->input('email', [
    'label' => __d('atcmobile', 'Email'),
]);
echo $this->Form->input('website', [
    'label' => __d('atcmobile', 'Website'),
]);
echo $this->Form->input('timezone', [
    'type' => 'select',
    'required' => true,
    'empty' => true,
    'options' => Time::listTimezones(),
    'label' => __d('atcmobile', 'Timezone'),
    'class' => 'c-select',
]);
echo $this->Form->input('role_id', [
    'label' => __d('atcmobile', 'Role'),
    'class' => 'c-select',
    'required' => true,
    'empty' => true,
]);
echo $this->Html->tabEnd();
$this->end();

$this->append('panels');
echo $this->Html->beginBox(__d('atcmobile', 'Publishing'));
echo $this->element('Atcmobapp/Core.admin/buttons', ['type' => 'user']);

if ($this->getRequest()->getParam('action') == 'add') :
    echo $this->Form->input('notification', [
        'label' => __d('atcmobile', 'Send Activation Email'),
        'type' => 'checkbox',
        'class' => false,
    ]);
endif;

echo $this->Form->input('status', [
    'label' => __d('atcmobile', 'Active'),
]);

$showPassword = !empty($user->status);
if ($this->getRequest()->getParam('action') == 'add') :
    $out = $this->Form->input('password', [
        'label' => __d('atcmobile', 'Password'),
        'disabled' => !$showPassword,
    ]);
    $out .= $this->Form->input('verify_password', [
        'label' => __d('atcmobile', 'Verify Password'),
        'disabled' => !$showPassword,
        'type' => 'password',
    ]);

    $this->Form->unlockField('password');
    $this->Form->unlockField('verify_password');

    echo $this->Html->div(null, $out, [
        'id' => 'passwords',
        'style' => $showPassword ? '' : 'display: none',
    ]);
endif;

echo $this->Html->endBox();

echo $this->Atcmobapp->adminBoxes();
$this->end();
