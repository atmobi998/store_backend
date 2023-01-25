<?php

use Cake\Core\App;

$this->extend('Atcmobapp/Core./Common/admin_index');

$clearUrl = [
    'prefix' => 'admin',
    'plugin' => 'Atcmobapp/Settings',
    'controller' => 'Caches',
    'action' => 'clear',
];

$this->Breadcrumbs->add(
    __d('atcmobile', 'Settings'),
    ['plugin' => 'Atcmobapp/Settings', 'controller' => 'Settings', 'action' => 'prefix', 'Site']
)
    ->add(__d('atcmobile', 'Caches'), $this->getRequest()->getUri()->getPath());

$this->append('action-buttons');
    echo $this->Atcmobapp->adminAction(__d('atcmobile', 'Clear All'), array_merge(
        $clearUrl,
        ['config' => 'all']
    ), [
        'method' => 'post',
        'tooltip' => [
            'data-title' => __d('atcmobile', 'Clear all cache'),
            'data-placement' => 'left',
        ],
        ]);
    $this->end();

    $tableHeaders = $this->Html->tableHeaders([
    $this->Paginator->sort('title', __d('atcmobile', 'Cache')),
    __d('atcmobile', 'Engine'),
    __d('atcmobile', 'Duration'),
    __d('atcmobile', 'Actions')
    ]);
    $this->append('table-heading', $tableHeaders);

    $rows = [];
    foreach ($caches as $cache => $engine) :
        $actions = [];
        $actions[] = $this->Atcmobapp->adminAction(
            '',
            array_merge($clearUrl, ['config' => $cache]),
            [
            'button' => false,
            'class' => 'red',
            'icon' => 'delete',
            'method' => 'post',
            'tooltip' => [
            'data-title' => __d('atcmobile', 'Clear cache: %s', $cache),
            'data-placement' => 'left',
            ],
            ]
        );
        $actions = $this->Html->div('item-actions', implode(' ', $actions));

        $rows[] = [
            $cache,
            App::shortName(get_class($engine), 'Cache/Engine', 'Engine'),
            $engine->getConfig('duration'),
            $actions,
        ];
    endforeach;

    $this->append('table-body', $this->Html->tableCells($rows));
