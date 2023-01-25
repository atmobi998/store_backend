<?php
$this->assign('title', __d('atcmobile', 'Database'));

$this->start('before');
echo $this->Form->create($context, [
    'align' => ['left' => 4, 'middle' => 8, 'right' => 0],
]);
$this->end();
?>
<?php if ($currentConfiguration['exists']) : ?>
    <div class="alert alert-warning">
        <strong><?= __d('atcmobile', 'Warning') ?>:</strong>
        <?= __d('atcmobile', 'A database configuration already exists.') ?>
        <?php
        if ($currentConfiguration['valid']) :
            $valid = __d('atcmobile', 'Valid');
            $class = 'text-success';
        else :
            $valid = __d('atcmobile', 'Invalid');
            $class = 'text-error';
        endif;
        echo __d('atcmobile', 'The configuration is %s.', $this->Html->tag('span', $valid, compact('class')));
        ?>
        <?php if ($currentConfiguration['valid']) : ?>
            <?php
            echo $this->Html->link(__d('atcmobile', 'Reuse this configuration and proceed'), ['action' => 'data']);
            ?>
            or complete the form below to replace it.
        <?php else : ?>
            <?= __d('atcmobile', 'This configuration will be replaced.') ?>
        <?php endif ?>
    </div>
<?php endif ?>

<?php
$validDrivers = array_merge([
    '' => __d('atcmobile', 'Please choose'),
], $drivers);

echo $this->Form->input('driver', [
    'placeholder' => __d('atcmobile', 'Database'),
    'empty' => false,
    'options' => $validDrivers,
    'required' => true,
]);
echo $this->Form->input('host', [
    'placeholder' => __d('atcmobile', 'Host'),
    'tooltip' => __d('atcmobile', 'Database hostname or IP Address'),
    'prepend' => $this->Html->icon('home'),
    'label' => __d('atcmobile', 'Host'),
]);
echo $this->Form->input('username', [
    'placeholder' => __d('atcmobile', 'Login'),
    'tooltip' => __d('atcmobile', 'Database login/username'),
    'prepend' => $this->Html->icon('user'),
    'label' => __d('atcmobile', 'Login'),
]);
echo $this->Form->input('password', [
    'placeholder' => __d('atcmobile', 'Password'),
    'tooltip' => __d('atcmobile', 'Database password'),
    'prepend' => $this->Html->icon('key'),
    'label' => __d('atcmobile', 'Password'),
]);
echo $this->Form->input('database', [
    'placeholder' => __d('atcmobile', 'Name'),
    'tooltip' => __d('atcmobile', 'Database name'),
    'prepend' => $this->Html->icon('briefcase'),
    'label' => __d('atcmobile', 'Name'),
]);
echo $this->Form->input('port', [
    'placeholder' => __d('atcmobile', 'Port'),
    'tooltip' => __d('atcmobile', 'Database port (leave blank if unknown)'),
    'prepend' => $this->Html->icon('asterisk'),
    'label' => __d('atcmobile', 'Port'),
]);
?>
<?php
$this->assign('buttons', $this->Form->button('Next step', ['class' => 'success']));

$this->assign('after', $this->Form->end());
