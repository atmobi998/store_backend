<?php

use Atcmobapp\Core\Status;

$this->Atcmobapp->adminScript(['Atcmobapp/Menus.admin']);

$this->extend('Atcmobapp/Core./Common/admin_index');

$this->Breadcrumbs->add(__d('atcmobile', 'Menus'), $this->getRequest()->getUri()->getPath());

$this->start('table-heading');
$tableHeaders = $this->Html->tableHeaders([
    $this->Paginator->sort('title', __d('atcmobile', 'Title')),
    $this->Paginator->sort('alias', __d('atcmobile', 'Alias')),
    $this->Paginator->sort('link_count', __d('atcmobile', 'Link Count')),
    $this->Paginator->sort('status', __d('atcmobile', 'Status')),
    __d('atcmobile', 'Actions'),
]);
echo $tableHeaders;
$this->end();

$this->start('table-body');
$rows = [];
foreach ($menus as $menu) :
    $actions = [];
    $actions[] = $this->Atcmobapp->adminRowAction(
        '',
        ['controller' => 'Links', 'action' => 'index', '?' => ['menu_id' => $menu->id]],
        ['icon' => $this->Theme->getIcon('inspect'), 'escapeTitle' => false, 'tooltip' => __d('atcmobile', 'View links')]
    );
    $actions[] = $this->Atcmobapp->adminRowActions($menu->id);
    $actions[] = $this->Atcmobapp->adminRowAction(
        '',
        ['controller' => 'Menus', 'action' => 'edit', $menu->id],
        ['icon' => $this->Theme->getIcon('update'), 'escapeTitle' => false, 'tooltip' => __d('atcmobile', 'Edit this item')]
    );
    $actions[] = $this->Atcmobapp->adminRowAction(
        '',
        ['controller' => 'Menus', 'action' => 'delete', $menu->id],
        ['icon' => $this->Theme->getIcon('delete'), 'escapeTitle' => false, 'tooltip' => __d('atcmobile', 'Remove this item')],
        __d('atcmobile', 'Are you sure?')
    );
    $actions = $this->Html->div('item-actions', implode(' ', $actions));

    $title = $this->Html->link($menu->title, [
        'controller' => 'Links',
        '?' => [
            'menu_id' => $menu->id,
        ],
    ]);

    if ($menu->status === Status::PREVIEW) {
        $title .= ' ' . $this->Html->tag('span', __d('atcmobile', 'preview'), ['class' => 'label label-warning']);
    }

    $status = $this->element('Atcmobapp/Core.admin/toggle', [
        'id' => $menu->id,
        'status' => (int)$menu->status,
    ]);

    $rows[] = [
        $title,
        $menu->alias,
        $menu->link_count,
        $status,
        $this->Html->div('item-actions', $actions),
    ];
endforeach;

echo $this->Html->tableCells($rows);

$this->end();
