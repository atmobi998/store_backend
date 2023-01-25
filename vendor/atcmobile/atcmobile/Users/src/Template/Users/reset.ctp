<div class="users form">
    <h2><?= $this->fetch('title'); ?></h2>
    <?= $this->Form->create($user); ?>
    <fieldset>
        <?= $this->Form->input('password', ['label' => __d('atcmobile', 'New password'), 'value' => '']); ?>
        <?= $this->Form->input('verify_password', ['type' => 'password', 'label' => __d('atcmobile', 'Verify Password')]); ?>
    </fieldset>
    <?= $this->Form->submit(__d('atcmobile', 'Reset')); ?>
    <?= $this->Form->end(); ?>
</div>
