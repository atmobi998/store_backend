<?php
echo $this->Form->input('comment_status', [
    'type' => 'radio',
    'options' => [
        '0' => __d('atcmobile', 'Disabled'),
        '1' => __d('atcmobile', 'Read only'),
        '2' => __d('atcmobile', 'Read/Write'),
    ],
    'default' => $type->comment_status,
    'legend' => false,
    'label' => false
]);
