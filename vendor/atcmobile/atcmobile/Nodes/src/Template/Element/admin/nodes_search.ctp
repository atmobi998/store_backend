<?php
echo $this->Form->create(null, [
    'align' => 'inline',
]);

$this->Form->setTemplates([
    'label' => false,
    'submitContainer' => '{{content}}',
]);

echo $this->Form->input('filter', [
    'title' => __d('atcmobile', 'Search'),
    'placeholder' => __d('atcmobile', 'Search...'),
    'tooltip' => false,
    'default' => $this->getRequest()->getQuery('filter'),
]);

echo $this->Form->input('type', [
    'options' => $nodeTypes,
    'empty' => __d('atcmobile', 'Type'),
    'class' => 'c-select',
    'default' => $this->getRequest()->getQuery('type'),
]);

if (!$this->getRequest()->getQuery('chooser')) :
    echo $this->Form->input('status', [
        'options' => [
            '1' => __d('atcmobile', 'Published'),
            '0' => __d('atcmobile', 'Unpublished'),
        ],
        'empty' => __d('atcmobile', 'Status'),
        'class' => 'c-select',
        'default' => $this->getRequest()->getQuery('status'),
    ]);

    echo $this->Form->input('promote', [
        'options' => [
            '1' => __d('atcmobile', 'Yes'),
            '0' => __d('atcmobile', 'No'),
        ],
        'empty' => __d('atcmobile', 'Promoted'),
        'class' => 'c-select',
        'default' => $this->getRequest()->getQuery('promote'),
    ]);
endif;

echo $this->Form->submit(__d('atcmobile', 'Filter'), [
    'class' => 'btn-outline-success mr-1',
]);
echo $this->Html->link('Reset', array_merge([
    'action' => 'index',
], [
    '?' => [
        'chooser' => $this->getRequest()->getQuery('chooser')
    ],
]), [
    'class' => 'btn btn-outline-secondary',
]);
echo $this->Form->end();
