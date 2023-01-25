<div class="settings view">
<h2><?= __d('atcmobile', 'Setting'); ?></h2>
    <dl><?php $i = 0;
    $class = ' class="altrow"';?>
        <dt<?php if ($i % 2 == 0) {
            echo $class;
           }?>><?= __d('atcmobile', 'Id'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) {
            echo $class;
           }?>>
            <?= $setting->id; ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) {
            echo $class;
           }?>><?= __d('atcmobile', 'Key'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) {
            echo $class;
           }?>>
            <?= $setting->key; ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) {
            echo $class;
           }?>><?= __d('atcmobile', 'Value'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) {
            echo $class;
           }?>>
            <?= $setting->value; ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) {
            echo $class;
           }?>><?= __d('atcmobile', 'Description'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) {
            echo $class;
           }?>>
            <?= $setting->description; ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) {
            echo $class;
           }?>><?= __d('atcmobile', 'Input Type'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) {
            echo $class;
           }?>>
            <?= $setting->input_type; ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) {
            echo $class;
           }?>><?= __d('atcmobile', 'Weight'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) {
            echo $class;
           }?>>
            <?= $setting->weight; ?>
            &nbsp;
        </dd>
        <dt<?php if ($i % 2 == 0) {
            echo $class;
           }?>><?= __d('atcmobile', 'Params'); ?></dt>
        <dd<?php if ($i++ % 2 == 0) {
            echo $class;
           }?>>
            <?= $setting->params; ?>
            &nbsp;
        </dd>
    </dl>
</div>
<div class="actions">
    <ul>
        <li><?= $this->Html->link(__d('atcmobile', 'Edit Setting'), ['action' => 'edit', $setting->id]); ?> </li>
        <li><?= $this->Form->postLink(__d('atcmobile', 'Delete Setting'), ['action' => 'delete', $setting->id], ['confirm' => __d('atcmobile', 'Are you sure you want to delete # %s?', $setting->id)]); ?> </li>
        <li><?= $this->Html->link(__d('atcmobile', 'List Settings'), ['action' => 'index']); ?> </li>
        <li><?= $this->Html->link(__d('atcmobile', 'New Setting'), ['action' => 'add']); ?> </li>
    </ul>
</div>
