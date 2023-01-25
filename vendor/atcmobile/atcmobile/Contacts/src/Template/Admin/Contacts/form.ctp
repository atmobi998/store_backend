<?php

$this->extend('Atcmobapp/Core./Common/admin_edit');

$this->Breadcrumbs->add(__d('atcmobile', 'Contacts'), ['controller' => 'Contacts', 'action' => 'index']);

if ($this->getRequest()->getParam('action') == 'edit') {
    $this->Breadcrumbs->add(h($contact->title), $this->getRequest()->getRequestTarget());
}

if ($this->getRequest()->getParam('action') == 'add') {
    $this->Breadcrumbs->add(__d('atcmobile', 'Add'), $this->getRequest()->getRequestTarget());
}

$this->append('form-start', $this->Form->create($contact));

$this->append('tab-heading');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Contact'), '#contact-basic');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Details'), '#contact-details');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Message'), '#contact-message');
$this->end();

$this->append('tab-content');

echo $this->Html->tabStart('contact-basic') . $this->Form->input('id') . $this->Form->input('title', [
        'label' => __d('atcmobile', 'Title'),
        'data-slug' => '#alias',
    ]) . $this->Form->input('alias', [
        'label' => __d('atcmobile', 'Alias'),
    ]) . $this->Form->input('email', [
        'label' => __d('atcmobile', 'Email'),
    ]) . $this->Form->input('body', [
        'label' => __d('atcmobile', 'Body'),
    ]);
    echo $this->Html->tabEnd();

    echo $this->Html->tabStart('contact-details') . $this->Form->input('name', [
        'label' => __d('atcmobile', 'Name'),
    ]) . $this->Form->input('position', [
        'label' => __d('atcmobile', 'Position'),
    ]) . $this->Form->input('address', [
        'label' => __d('atcmobile', 'Address'),
    ]) . $this->Form->input('address2', [
        'label' => __d('atcmobile', 'Address2'),
    ]) . $this->Form->input('state', [
        'label' => __d('atcmobile', 'State'),
    ]) . $this->Form->input('country', [
        'label' => __d('atcmobile', 'Country'),
    ]) . $this->Form->input('postcode', [
        'label' => __d('atcmobile', 'Post Code'),
    ]) . $this->Form->input('phone', [
        'label' => __d('atcmobile', 'Phone'),
    ]) . $this->Form->input('fax', [
        'label' => __d('atcmobile', 'Fax'),
    ]);
    echo $this->Html->tabEnd();

    echo $this->Html->tabStart('contact-message') . $this->Form->input('message_status', [
        'label' => __d('atcmobile', 'Let users leave a message'),
    ]) . $this->Form->input('message_archive', [
        'label' => __d('atcmobile', 'Save messages in database'),
    ]) . $this->Form->input('message_notify', [
        'label' => __d('atcmobile', 'Notify by email instantly'),
    ]) . $this->Form->input('message_spam_protection', [
        'label' => __d('atcmobile', 'Spam protection (requires Akismet API key)'),
    ]) . $this->Form->input('message_captcha', [
        'label' => __d('atcmobile', 'Use captcha? (requires Recaptcha API key)'),
    ]);

    echo $this->Html->link(__d('atcmobile', 'You can manage your API keys here.'), [
    'plugin' => 'Atcmobapp/Settings',
    'controller' => 'Settings',
    'action' => 'prefix',
    'Service',
    ]);
    echo $this->Html->tabEnd();
    $this->end();

    $this->append('panels');
    echo $this->Html->beginBox(__d('atcmobile', 'Publishing'));
    echo $this->element('Atcmobapp/Core.admin/buttons', ['type' => 'contact']);
    echo $this->Form->input('status', [
        'label' => __d('atcmobile', 'Published'),
    ]);
    echo $this->Html->endBox();
    $this->end();
