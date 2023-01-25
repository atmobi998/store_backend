<?php
$this->assign('title', __d('atcmobile', 'Edit Message'));
$this->extend('/Common/admin_edit');

$this->Breadcrumbs->add(
    __d('atcmobile', 'Contacts'),
    ['plugin' => 'Atcmobapp/Contacts', 'controller' => 'Contacts', 'action' => 'index']
)
    ->add(
        __d('atcmobile', 'Messages'),
        ['plugin' => 'Atcmobapp/Contacts', 'controller' => 'Messages', 'action' => 'index']
    );

if ($this->getRequest()->getParam('action') == 'edit') {
    $this->Breadcrumbs->add(h($message->title), $this->getRequest()->getRequestTarget());
}

$this->append('form-start', $this->Form->create($message));

$this->append('tab-heading');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Message'), '#message-main');
$this->end();

$this->append('tab-content');

echo $this->Html->tabStart('message-main') . $this->Form->input('name', [
        'label' => __d('atcmobile', 'Name'),
    ]) . $this->Form->input('email', [
        'label' => __d('atcmobile', 'Email'),
    ]) . $this->Form->input('title', [
        'label' => __d('atcmobile', 'Title'),
    ]) . $this->Form->input('body', [
        'label' => __d('atcmobile', 'Body'),
    ]) . $this->Form->input('phone', [
        'label' => __d('atcmobile', 'Phone'),
    ]) . $this->Form->input('address', [
        'label' => __d('atcmobile', 'Address'),
    ]);
    echo $this->Html->tabEnd();
    $this->end();
