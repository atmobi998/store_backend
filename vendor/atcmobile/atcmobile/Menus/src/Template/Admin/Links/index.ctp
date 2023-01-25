<?php

use Atcmobapp\Core\Status;

$this->Atcmobapp->adminscript('Atcmobapp/Menus.admin');

$this->extend('Atcmobapp/Core./Common/admin_index');

$this->Breadcrumbs->add(__d('atcmobile', 'Menus'), ['controller' => 'Menus', 'action' => 'index'])
    ->add(h(__d('atcmobile', $menu->title)), $this->getRequest()->getRequestTarget());

$this->append('action-buttons');
echo $this->Atcmobapp->adminAction(__d('atcmobile', 'New link'), ['action' => 'add', 'menu_id' => $menu->id]);
$this->end();

$this->append('form-start', $this->Form->create(null, [
    'align' => 'inline',
    'url' => [
        'action' => 'process',
        $menu->id,
    ],
]));

$this->start('table-heading');
$tableHeaders = $this->Html->tableHeaders([
    $this->Form->checkbox('checkAll', ['id' => 'LinksCheckAll']),
    __d('atcmobile', 'Title'),
    __d('atcmobile', 'Status'),
    __d('atcmobile', 'Actions'),
]);
echo $tableHeaders;
$this->end();

$this->append('table-body');
$rows = [];
foreach ($linksTree as $linkId => $linkTitle) :
    $actions = [];
    $actions[] = $this->Atcmobapp->adminRowAction('', [
        'action' => 'moveUp',
        $linkId,
    ], [
        'icon' => $this->Theme->getIcon('move-up'),
        'escapeTitle' => false,
        'tooltip' => __d('atcmobile', 'Move up'),
    ]);
    $actions[] = $this->Atcmobapp->adminRowAction('', [
        'action' => 'moveDown',
        $linkId,
    ], [
        'icon' => $this->Theme->getIcon('move-down'),
        'escapeTitle' => false,
        'tooltip' => __d('atcmobile', 'Move down'),
    ]);
    $actions[] = $this->Atcmobapp->adminRowActions($linkId);
    $actions[] = $this->Atcmobapp->adminRowAction('', [
        'action' => 'edit',
        $linkId,
    ], [
        'icon' => $this->Theme->getIcon('update'),
        'escapeTitle' => false,
        'tooltip' => __d('atcmobile', 'Edit this item'),
    ]);
    $actions[] = $this->Atcmobapp->adminRowAction('', '#Link' . $linkId . 'Id', [
        'icon' => $this->Theme->getIcon('copy'),
        'escapeTitle' => false,
        'tooltip' => __d('atcmobile', 'Create a copy'),
        'rowAction' => 'copy',
    ], __d('atcmobile', 'Create a copy of this Link?'));
    $actions[] = $this->Atcmobapp->adminRowAction('', '#Link' . $linkId . 'Id', [
        'icon' => $this->Theme->getIcon('delete'),
        'escapeTitle' => false,
        'class' => 'delete',
        'tooltip' => __d('atcmobile', 'Delete this item'),
        'rowAction' => 'delete',
    ], __d('atcmobile', 'Are you sure?'));
    $actions = $this->Html->div('item-actions', implode(' ', $actions));
    if ($linksStatus[$linkId] == Status::PREVIEW) {
        $linkTitle .= ' ' . $this->Html->tag('span', __d('atcmobile', 'preview'), ['class' => 'label label-warning']);
    }
    $rows[] = [
        $this->Form->checkbox('Links.' . $linkId . '.id', ['class' => 'row-select', 'id' => 'Link' . $linkId . 'Id']),
        $linkTitle,
        $this->element('Atcmobapp/Core.admin/toggle', [
            'id' => $linkId,
            'status' => (int)$linksStatus[$linkId],
        ]),
        $actions,
    ];
endforeach;

echo $this->Html->tableCells($rows);

$this->end();

$this->start('bulk-action');

echo $this->Form->input('action', [
    'class' => 'c-select',
    'label' => __d('atcmobile', 'Bulk actions'),
    'options' => [
        'publish' => __d('atcmobile', 'Publish'),
        'unpublish' => __d('atcmobile', 'Unpublish'),
        'delete' => __d('atcmobile', 'Delete'),
        [
            'value' => 'copy',
            'text' => __d('atcmobile', 'Copy'),
            'hidden' => true,
        ],
    ],
    'empty' => __d('atcmobile', 'Bulk actions'),
]);

echo $this->Form->button(__d('atcmobile', 'Apply'), [
    'type' => 'submit',
    'value' => 'submit',
    'class' => 'btn-outline-primary'
]);
$this->end();
