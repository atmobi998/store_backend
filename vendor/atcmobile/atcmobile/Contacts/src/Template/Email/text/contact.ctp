<?php

use Cake\Routing\Router;

$url = Router::url([
    'controller' => 'Contacts',
    'action' => 'view',
    $contact->alias,
], true);
echo __d('atcmobile', 'You have received a new message at: %s', $url) . "\n \n";
echo __d('atcmobile', 'Name: %s', $message->name) . "\n";
echo __d('atcmobile', 'Email: %s', $message->email) . "\n";
echo __d('atcmobile', 'Subject: %s', $message->title) . "\n";
echo __d('atcmobile', 'IP Address: %s', $_SERVER['REMOTE_ADDR']) . "\n";
echo __d('atcmobile', 'Message: %s', $message->body) . "\n";
