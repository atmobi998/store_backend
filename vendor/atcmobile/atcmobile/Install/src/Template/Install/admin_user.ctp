<?php
$this->assign('before', $this->Form->create($user, [
    'align' => ['left' => 4, 'middle' => 8, 'right' => 0],
]));
?>
<?php
echo $this->Form->input('username', [
    'placeholder' => __d('atcmobile', 'Username'),
    'prepend' => $this->Html->icon('user'),
    'label' => __d('atcmobile', 'Username'),
    'value' => 'admin',
]);
echo $this->Form->input('password', [
    'placeholder' => __d('atcmobile', 'New Password'),
    'value' => 'ptGNBVCd9Jrjs9k8m8U',
    'prepend' => $this->Html->icon('key'),
    'label' => __d('atcmobile', 'New Password'),
]);
echo $this->Form->input('verify_password', [
    'placeholder' => __d('atcmobile', 'Verify Password'),
    'type' => 'password',
    'value' => 'ptGNBVCd9Jrjs9k8m8U',
    'prepend' => $this->Html->icon('key'),
    'label' => __d('atcmobile', 'Verify Password'),
]);
echo $this->Form->input('firstname', [
    'placeholder' => __d('atcmobile', 'Firstname'),
    'prepend' => $this->Html->icon('user'),
    'label' => __d('atcmobile', 'Firstname'),
    'value' => 'Administrator',
]);
echo $this->Form->input('lastname', [
    'placeholder' => __d('atcmobile', 'Lastname'),
    'prepend' => $this->Html->icon('user'),
    'label' => __d('atcmobile', 'Lastname'),
    'value' => 'User',
]);
echo $this->Form->input('email', [
    'placeholder' => __d('atcmobile', 'Email'),
    'prepend' => $this->Html->icon('voicemail'),
    'label' => __d('atcmobile', 'Email'),
    'value' => 'hotranan@gmail.com',
]);
echo $this->Form->input('website', [
    'placeholder' => __d('atcmobile', 'Website'),
    'prepend' => $this->Html->icon('home'),
    'label' => __d('atcmobile', 'Website'),
    'value' => 'store.metroeconomics.com',
]);
echo $this->Form->input('phone', [
    'placeholder' => __d('atcmobile', 'Phone'),
    'prepend' => $this->Html->icon('phone'),
    'label' => __d('atcmobile', 'Phone'),
    'value' => '+84-979-547-863',
]);

?>
<?php
$this->assign('buttons', $this->Form->button(__d('atcmobile', 'Finalize installation'), ['class' => 'success']));
$this->assign('after', $this->Form->end());
