<?php

$this->extend('Atcmobapp/Core./Common/admin_view');

$this->Breadcrumbs
    ->add(__d('atcmobile', 'Messages'), ['action' => 'index']);

    $this->Breadcrumbs->add(h($message->title), $this->getRequest()->getRequestTarget());

$this->append('action-buttons');
    echo $this->Atcmobapp->adminAction(__d('atcmobile', 'List Messages'), ['action' => 'index']);
$this->end();

$this->append('main');
?>
<div class="messages view large-9 medium-8 columns">
    <table class="table vertical-table">
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Contact') ?></th>
            <td><?= $message->has('contact') ? $this->Html->link($message->contact->name, ['controller' => 'Contacts', 'action' => 'view', $message->contact->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Name') ?></th>
            <td><?= h($message->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Email') ?></th>
            <td><?= h($message->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Title') ?></th>
            <td><?= h($message->title) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Website') ?></th>
            <td><?= h($message->website) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Phone') ?></th>
            <td><?= h($message->phone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Message Type') ?></th>
            <td><?= h($message->message_type) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Trackable Updater') ?></th>
            <td><?= $message->has('trackable_updater') ? $this->Html->link($message->trackable_updater->name, ['controller' => 'Users', 'action' => 'view', $message->trackable_updater->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Trackable Creator') ?></th>
            <td><?= $message->has('trackable_creator') ? $this->Html->link($message->trackable_creator->name, ['controller' => 'Users', 'action' => 'view', $message->trackable_creator->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Id') ?></th>
            <td><?= $this->Number->format($message->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Modified') ?></th>
            <td><?= $this->Time->i18nFormat($message->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Created') ?></th>
            <td><?= $this->Time->i18nFormat($message->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Status') ?></th>
            <td><?= $message->status ? __d('atcmobile', 'Yes') : __d('atcmobile', 'No'); ?></td>
        </tr>
    </table>
    <div>
        <label>
            <strong><?= __d('atcmobile', 'Body') ?></strong>
        </label>
        <?= $this->Text->autoParagraph(h($message->body)); ?>
    </div>
    <div>
        <label>
            <strong><?= __d('atcmobile', 'Address') ?></strong>
        </label>
        <?= $this->Text->autoParagraph(h($message->address)); ?>
    </div>
</div>
<?php
$this->end();
