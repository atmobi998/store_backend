<?php

$this->extend('Atcmobapp/Core./Common/admin_index');

$this->Breadcrumbs->add(
    __d('atcmobile', 'Settings'),
    ['plugin' => 'Atcmobapp/Settings', 'controller' => 'Settings', 'action' => 'prefix', 'Site']
)
    ->add(__d('atcmobile', 'Languages'), $this->getRequest()->getUri()->getPath());

$tableHeaders = $this->Html->tableHeaders([
    $this->Paginator->sort('title', __d('atcmobile', 'Title')),
    $this->Paginator->sort('native', __d('atcmobile', 'Native')),
    $this->Paginator->sort('alias', __d('atcmobile', 'Alias')),
    $this->Paginator->sort('locale', __d('atcmobile', 'Locale')),
    $this->Paginator->sort('status', __d('atcmobile', 'Status')),
    __d('atcmobile', 'Actions'),
]);
$this->append('table-heading', $tableHeaders);

$rows = [];
foreach ($languages as $language) {
    $actions = [];
    $actions[] = $this->Atcmobapp->adminRowActions($language->id);
    $actions[] = $this->Atcmobapp->adminRowAction('', ['action' => 'moveUp', $language->id], [
        'icon' => $this->Theme->getIcon('move-up'),
        'escapeTitle' => false,
        'tooltip' => __d('atcmobile', 'Move up'),
    ]);
    $actions[] = $this->Atcmobapp->adminRowAction('', ['action' => 'moveDown', $language->id], [
        'icon' => $this->Theme->getIcon('move-down'),
        'escapeTitle' => false,
        'tooltip' => __d('atcmobile', 'Move down'),
    ]);
    $actions[] = $this->Atcmobapp->adminRowAction('', ['action' => 'edit', $language->id], [
        'icon' => $this->Theme->getIcon('update'),
        'escapeTitle' => false,
        'tooltip' => __d('atcmobile', 'Edit this item'),
    ]);
    $actions[] = $this->Atcmobapp->adminRowAction('', ['action' => 'delete', $language->id], [
        'icon' => $this->Theme->getIcon('delete'),
        'escapeTitle' => false,
        'tooltip' => __d('atcmobile', 'Remove this item')
    ], __d('atcmobile', 'Are you sure?'));

    $actions = $this->Html->div('item-actions', implode(' ', $actions));

    $rows[] = [
        $language->title,
        $language->native,
        $language->alias,
        $language->locale,
        $this->Html->status($language->status),
        $actions,
    ];
}

$this->append('table-body', $this->Html->tableCells($rows));
