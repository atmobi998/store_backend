<?php

$this->extend('Atcmobapp/Core./Common/admin_index');

$this->Breadcrumbs->add(
    __d('atcmobile', 'Content'),
    ['plugin' => 'Atcmobapp/Nodes', 'controller' => 'Nodes', 'action' => 'index']
)
    ->add(__d('atcmobile', 'Vocabularies'), $this->getRequest()->getRequestTarget());

$this->start('table-heading');
$tableHeaders = $this->Html->tableHeaders([
    $this->Paginator->sort('title', __d('atcmobile', 'Title')),
    $this->Paginator->sort('alias', __d('atcmobile', 'Alias')),
    $this->Paginator->sort('plugin', __d('atcmobile', 'Plugin')),
    __d('atcmobile', 'Actions'),
]);

echo $tableHeaders;
$this->end();

$this->append('table-body');
$rows = [];
foreach ($vocabularies as $vocabulary) :
    $actions = [];
    $actions[] = $this->Atcmobapp->adminRowAction(
        '',
        ['controller' => 'Taxonomies', 'action' => 'index', '?' => ['vocabulary_id' => $vocabulary->id]],
        ['icon' => $this->Theme->getIcon('view'), 'escapeTitle' => false, 'tooltip' => __d('atcmobile', 'View terms')]
    );
    $actions[] = $this->Atcmobapp->adminRowAction(
        '',
        ['action' => 'moveUp', $vocabulary->id],
        ['icon' => $this->Theme->getIcon('move-up'), 'escapeTitle' => false, 'tooltip' => __d('atcmobile', 'Move up'), 'method' => 'post']
    );
    $actions[] = $this->Atcmobapp->adminRowAction(
        '',
        ['action' => 'moveDown', $vocabulary->id],
        ['icon' => $this->Theme->getIcon('move-down'), 'escapeTitle' => false, 'tooltip' => __d('atcmobile', 'Move down'), 'method' => 'post']
    );
    $actions[] = $this->Atcmobapp->adminRowActions($vocabulary->id);
    $actions[] = $this->Atcmobapp->adminRowAction(
        '',
        ['action' => 'edit', $vocabulary->id],
        ['icon' => $this->Theme->getIcon('update'), 'escapeTitle' => false, 'tooltip' => __d('atcmobile', 'Edit this item')]
    );
    $actions[] = $this->Atcmobapp->adminRowAction(
        '',
        ['action' => 'delete', $vocabulary->id],
        ['icon' => $this->Theme->getIcon('delete'), 'escapeTitle' => false, 'tooltip' => __d('atcmobile', 'Remove this item')],
        __d('atcmobile', 'Are you sure?')
    );
    $actions = $this->Html->div('item-actions', implode(' ', $actions));
    $rows[] = [
        $this->Html->link($vocabulary->title, ['controller' => 'Taxonomies', 'action' => 'index', '?' => ['vocabulary_id' => $vocabulary->id]]),
        $vocabulary->alias,
        $vocabulary->plugin,
        $actions,
    ];
endforeach;

echo $this->Html->tableCells($rows);

$this->end();
