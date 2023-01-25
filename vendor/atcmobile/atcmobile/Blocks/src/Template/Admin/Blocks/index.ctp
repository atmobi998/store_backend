<?php

use Atcmobapp\Core\Status;

$this->Atcmobapp->adminScript('Atcmobapp/Blocks.admin');

$this->extend('Atcmobapp/Core./Common/admin_index');

$this->Breadcrumbs->add(__d('atcmobile', 'Blocks'), $this->getRequest()->getUri()->getPath());

$this->append('form-start', $this->Form->create(null, [
    'url' => ['action' => 'process'],
    'align' => 'inline'
]));

$chooser = $this->getRequest()->getQuery('chooser');
$this->start('table-heading');
$tableHeaders = $this->Html->tableHeaders([
    $this->Form->checkbox('checkAll', ['id' => 'BlocksCheckAll']),
    $this->Paginator->sort('title', __d('atcmobile', 'Title')),
    $this->Paginator->sort('alias', __d('atcmobile', 'Alias')),
    $this->Paginator->sort('region_id', __d('atcmobile', 'Region')),
    $this->Paginator->sort('modified', __d('atcmobile', 'Modified')),
    $this->Paginator->sort('status', __d('atcmobile', 'Status')),
    __d('atcmobile', 'Actions'),
]);
echo $tableHeaders;
$this->end();

$this->append('table-body');
$rows = [];
foreach ($blocks as $block) {
    $actions = [];
    $actions[] = $this->Atcmobapp->adminRowAction('', ['action' => 'moveUp', $block->id], [
            'icon' => $this->Theme->getIcon('move-up'),
            'escapeTitle' => false,
            'tooltip' => __d('atcmobile', 'Move up'),
            'method' => 'post',
        ]);
    $actions[] = $this->Atcmobapp->adminRowAction('', ['action' => 'moveDown', $block->id], [
            'icon' => $this->Theme->getIcon('move-down'),
            'escapeTitle' => false,
            'tooltip' => __d('atcmobile', 'Move down'),
            'method' => 'post',
        ]);
    $actions[] = $this->Atcmobapp->adminRowActions($block->id);
    $actions[] = $this->Atcmobapp->adminRowAction('', ['action' => 'edit', $block->id],
        ['icon' => $this->Theme->getIcon('update'), 'escapeTitle' => false, 'tooltip' => __d('atcmobile', 'Edit this item')]);
    $actions[] = $this->Atcmobapp->adminRowAction('', '#Blocks' . $block->id . 'Id', [
            'icon' => $this->Theme->getIcon('copy'),
            'escapeTitle' => false,
            'tooltip' => __d('atcmobile', 'Create a copy'),
            'rowAction' => 'copy',
        ], __d('atcmobile', 'Create a copy of this Block?'));
    $actions[] = $this->Atcmobapp->adminRowAction('', '#Blocks' . $block->id . 'Id', [
            'icon' => $this->Theme->getIcon('delete'),
            'escapeTitle' => false,
            'class' => 'delete',
            'tooltip' => __d('atcmobile', 'Remove this item'),
            'rowAction' => 'delete',
        ], __d('atcmobile', 'Are you sure?'));

    if ($chooser) {
        $checkbox = null;
        $actions = [
            $this->Atcmobapp->adminRowAction(__d('atcmobile', 'Choose'), '#', [
                'class' => 'item-choose',
                'data-chooser-type' => 'Block',
                'data-chooser-id' => $block->id,
                'data-chooser-title' => $block->title,
            ]),
        ];
    } else {
        $checkbox = $this->Form->checkbox('Blocks.' . $block->id . '.id', [
            'class' => 'row-select',
            'id' => 'Blocks' . $block->id . 'Id',
        ]);
    }

    $actions = $this->Html->div('item-actions', implode(' ', $actions));
    $title = $this->Html->link($block->title, [
        'action' => 'edit',
        $block->id,
    ]);

    if ($block->status == Status::PREVIEW) {
        $title .= ' ' . $this->Html->tag('span', __d('atcmobile', 'preview'), ['class' => 'label label-warning']);
    }

    $rows[] = [
        $checkbox,
        $title,
        $block->alias,
        $block->region->title,
        $block->modified,
        $this->element('Atcmobapp/Core.admin/toggle', [
            'id' => $block->id,
            'status' => (int)$block->status,
        ]),
        $actions,
    ];
}

echo $this->Html->tableCells($rows);
?>
    </table>
<?php
$this->end();
if (!$chooser):
    $this->start('bulk-action');
    echo $this->Form->input('action', [
        'label' => __d('atcmobile', 'Bulk action'),
        'class' => 'c-select',
        'options' => [
            'publish' => __d('atcmobile', 'Publish'),
            'unpublish' => __d('atcmobile', 'Unpublish'),
            'delete' => __d('atcmobile', 'Delete'),
            'copy' => __d('atcmobile', 'Copy'),
        ],
        'empty' => __d('atcmobile', 'Bulk action'),
    ]);
    echo $this->Form->button(__d('atcmobile', 'Submit'), [
        'type' => 'submit',
        'value' => 'submit',
        'class' => 'btn-outline-primary'
    ]);
    $this->end();
endif;
