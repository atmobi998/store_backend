<?php

$this->extend('Atcmobapp/Core./Common/admin_view');

$this->Breadcrumbs
    ->add(__d('atcmobile', 'Users'), ['action' => 'index'])
    ->add($user->name, $this->getRequest()->getRequestTarget());

$this->append('action-buttons');
    echo $this->Atcmobapp->adminAction(__d('atcmobile', 'Edit User'), ['action' => 'edit', $user->id]);
$this->end();

$this->append('main');
?>
<div class="users view large-9 medium-8 columns">
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Role') ?></th>
            <td><?= $user->has('role') ? $this->Html->link($user->role->title, ['controller' => 'Roles', 'action' => 'view', $user->role->id]) : '' ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Username') ?></th>
            <td><?= h($user->username) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Name') ?></th>
            <td><?= h($user->name) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Email') ?></th>
            <td><?= h($user->email) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Website') ?></th>
            <td><?= h($user->website) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Timezone') ?></th>
            <td><?= h($user->timezone) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Modified By') ?></th>
            <td><?= $this->Number->format($user->modified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Created By') ?></th>
            <td><?= $this->Number->format($user->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Modified') ?></th>
            <td><?= $this->Time->i18nFormat($user->modified) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Created') ?></th>
            <td><?= $this->Time->i18nFormat($user->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __d('atcmobile', 'Status') ?></th>
            <td><?= $user->status ? __d('atcmobile', 'Yes') : __d('atcmobile', 'No'); ?></td>
        </tr>
    </table>
    <div>
        <label>
            <strong><?= __d('atcmobile', 'Bio') ?></strong>
        </label>
        <?= $this->Text->autoParagraph(h($user->bio)); ?>
    </div>
</div>
<?php
$this->end();
