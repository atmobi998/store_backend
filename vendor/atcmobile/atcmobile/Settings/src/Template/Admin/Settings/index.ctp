<?php

$this->extend('Atcmobapp/Core./Common/admin_index');

$this->Breadcrumbs
    ->add(__d('atcmobile', 'Settings'), [
        'prefix' => 'admin',
        'plugin' => 'Atcmobapp/Settings',
        'controller' => 'Settings',
        'action' => 'index',
    ]);

$key = $this->getRequest()->getQuery('key');
if ($key) {
    $this->Breadcrumbs->add($key);
}

$this->start('table-heading');
    $tableHeaders = $this->Html->tableHeaders([
        $this->Paginator->sort('id', __d('atcmobile', 'Id')),
        $this->Paginator->sort('key', __d('atcmobile', 'Key')),
        $this->Paginator->sort('value', __d('atcmobile', 'Value')),
        $this->Paginator->sort('editable', __d('atcmobile', 'Editable')),
        __d('atcmobile', 'Actions'),
    ]);
    echo $tableHeaders;
    $this->end();

    $this->append('table-body');
    $rows = [];
    foreach ($settings as $setting) :
        $actions = [];
        $actions[] = $this->Atcmobapp->adminRowAction(
            '',
            ['controller' => 'Settings', 'action' => 'moveup', $setting->id],
            [
            'icon' => $this->Theme->getIcon('move-up'),
            'escapeTitle' => false,
            'tooltip' => __d('atcmobile', 'Move up'),
            ]
        );
        $actions[] = $this->Atcmobapp->adminRowAction(
            '',
            ['controller' => 'Settings', 'action' => 'movedown', $setting->id],
            [
            'icon' => $this->Theme->getIcon('move-down'),
            'escapeTitle' => false,
            'tooltip' => __d('atcmobile', 'Move down')
            ]
        );
        $actions[] = $this->Atcmobapp->adminRowAction(
            '',
            ['controller' => 'Settings', 'action' => 'edit', $setting->id],
            [
            'icon' => $this->Theme->getIcon('update'),
            'escapeTitle' => false,
            'tooltip' => __d('atcmobile', 'Edit this item')
            ]
        );
        $actions[] = $this->Atcmobapp->adminRowActions($setting->id);
        $actions[] = $this->Atcmobapp->adminRowAction(
            '',
            ['controller' => 'Settings', 'action' => 'delete', $setting->id],
            [
            'icon' => $this->Theme->getIcon('delete'),
            'escapeTitle' => false,
            'tooltip' => __d('atcmobile', 'Remove this item')
            ],
            __d('atcmobile', 'Are you sure?')
        );

        $key = $setting->key;
        $keyE = explode('.', $key);
        $keyPrefix = $keyE['0'];
        if (isset($keyE['1'])) {
            $keyTitle = '.' . $keyE['1'];
        } else {
            $keyTitle = '';
        }
        $actions = $this->Html->div('item-actions', implode(' ', $actions));
        $rows[] = [
            $setting->id,
            $this->Html->link($keyPrefix, ['controller' => 'Settings', 'action' => 'index', '?' => ['key' => $keyPrefix]]) . $keyTitle,
            $this->Text->truncate(h($setting->value), 20),
            $this->Html->status($setting->editable),
            $actions,
        ];
    endforeach;

    echo $this->Html->tableCells($rows);
    $this->end();
