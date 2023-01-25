<?php
/**
 * @var \Atcmobapp\Core\View\AtcmobappView $this
 */

use Atcmobapp\Core\Status;

echo $this->Form->control('status', [
    'label' => __d('atcmobile', 'Status'),
    'class' => 'c-select',
    'default' => Status::UNPUBLISHED,
    'options' => $this->Atcmobapp->statuses(),
]);

echo $this->Html->div('input-daterange', $this->Form->control('publish_start', [
        'label' => __d('atcmobile', 'Publish on'),
        'data-format' => 'Y-m-d H:i:s',
        'empty' => true,
    ]) . $this->Form->control('publish_end', [
        'label' => __d('atcmobile', 'Un-publish on'),
        'data-format' => 'Y-m-d H:i:s',
        'empty' => true,
    ]));
