<?php

$this->assign('title', __d('atcmobile', 'Forgot Password'));

?>
<div class="users form">
    <h2><?= $this->fetch('title') ?></h2>
    <?= $this->Form->create('User', ['url' => ['controller' => 'Users', 'action' => 'forgot']]);?>
        <fieldset>
        <?= $this->Form->input('username', [
            'label' => __d('atcmobile', 'Username'),
            'required' => true,
        ]) ?>
        </fieldset>
        <?= $this->Form->submit(__d('atcmobile', 'Submit')) ?>
    <?= $this->Form->end() ?>
</div>
