<?php

use Atcmobapp\Core\Status;

$this->assign('title', __d('atcmobile', 'Content Tree'));

$this->extend('Atcmobapp/Core./Common/admin_index');
$this->Atcmobapp->adminScript('Atcmobapp/Nodes.admin');

$indexUrl = [
    'prefix' => 'admin',
    'plugin' => 'Atcmobapp/Nodes',
    'controller' => 'Nodes',
    'action' => 'index',
];
$this->Breadcrumbs
    ->add(__d('atcmobile', 'Content'), $indexUrl);

if (isset($type) && $this->getRequest()->getQuery('type')) :
    $typeUrl = array_merge($indexUrl, [
        'type' => $type->alias,
    ]);
    $this->Breadcrumbs->add($type->title, $typeUrl);
endif;

$this->append('action-buttons');
    echo $this->Atcmobapp->adminAction(
        __d('atcmobile', 'New %s', $type->title),
        [
            'action' => 'add',
            $type->alias,
        ]
    );
    $this->end();

    $this->append('search', $this->element('admin/nodes_search'));

    $this->append('form-start', $this->Form->create(
        'Node',
        [
        'url' => ['controller' => 'Nodes', 'action' => 'process'],
        'class' => 'form-inline'
        ]
    ));

    $this->start('table-heading');
    $tableHeaders = $this->Html->tableHeaders([
        $this->Form->checkbox('checkAll'),
        __d('atcmobile', 'Id'),
        __d('atcmobile', 'Title'),
        __d('atcmobile', 'Type'),
        __d('atcmobile', 'User'),
        __d('atcmobile', 'Status'),
        ''
    ]);
    echo $this->Html->tag('thead', $tableHeaders);
    $this->end();

    $this->append('table-body');
    ?>
<?php foreach ($nodes as $node) : ?>
    <tr>
        <td><?php echo $this->Form->checkbox('Node.' . $node['Node']['id'] . '.id', ['class' => 'row-select']); ?></td>
        <td><?php echo $node->id; ?></td>
        <td class="level-<?php echo $node->depth; ?>">
            <span>
            <?php
                echo $this->Html->link($node->title, [
                    'admin' => false,
                    'controller' => 'Nodes',
                    'action' => 'view',
                    'type' => $node->type,
                    'slug' => $node->slug,
                ]);
            ?>
            </span>

            <?php if ($node->promote == 1) : ?>
            <span class="badge badge-info"><?php echo __d('atcmobile', 'promoted'); ?></span>
            <?php endif ?>

            <?php if ($node->status == Status::PREVIEW) : ?>
            <span class="badge badge-warning"><?php echo __d('atcmobile', 'preview'); ?></span>
            <?php endif ?>
        </td>
        <td>
            <?php echo $node->type; ?>
        </td>
        <td>
            <?php echo $node->username; ?>
        </td>
        <td>
            <?php
                echo $this->element('admin/toggle', [
                    'id' => $node->id,
                    'status' => (int)$node->status,
                ]);
            ?>
        </td>
        <td>
            <div class="item-actions">
            <?php
                echo $this->Atcmobapp->adminRowActions($node->id);

                echo $this->Atcmobapp->adminRowAction(
                    '',
                    ['controller' => 'Nodes', 'action' => 'move', $node->id, 'up'],
                    [
                        'icon' => $this->Theme->getIcon('move-up'),
                        'escapeTitle' => false,
                        'tooltip' => __d('atcmobile', 'Move up'),
                    ]
                );
                echo $this->Atcmobapp->adminRowAction(
                    '',
                    ['controller' => 'Nodes', 'action' => 'move', $node->id, 'down'],
                    [
                        'icon' => $this->Theme->getIcon('move-down'),
                        'escapeTitle' => false,
                        'tooltip' => __d('atcmobile', 'Move down'),
                    ]
                );
                echo ' ' . $this->Atcmobapp->adminRowAction(
                    '',
                    ['action' => 'edit', $node->id],
                    [
                        'icon' => $this->Theme->getIcon('update'),
                        'escapeTitle' => false,
                        'tooltip' => __d('atcmobile', 'Edit this item')
                    ]
                );
                echo ' ' . $this->Atcmobapp->adminRowAction(
                    '',
                    '#Node' . $node->id . 'Id',
                    [
                        'icon' => $this->Theme->getIcon('delete'),
                        'escapeTitle' => false,
                        'class' => 'delete',
                        'tooltip' => __d('atcmobile', 'Remove this item'),
                        'rowAction' => 'delete',
                    ],
                    __d('atcmobile', 'Are you sure?')
                );
            ?>
            </div>
        </td>
    </tr>
<?php endforeach ?>
<?php
$this->end();

$this->start('bulk-action');
    echo $this->Form->input('action', [
        'label' => false,
        'class' => 'c-select',
        'options' => [
            'publish' => __d('atcmobile', 'Publish'),
            'unpublish' => __d('atcmobile', 'Unpublish'),
            'promote' => __d('atcmobile', 'Promote'),
            'unpromote' => __d('atcmobile', 'Unpromote'),
            'delete' => __d('atcmobile', 'Delete'),
            'copy' => [
                'value' => 'copy',
                'name' => __d('atcmobile', 'Copy'),
                'hidden' => true,
            ],
        ],
        'empty' => 'Bulk actions',
    ]);

    $jsVarName = uniqid('confirmMessage_');
    $button = $this->Form->button(__d('atcmobile', 'Apply'), [
        'type' => 'button',
        'class' => 'bulk-process btn-outline-primary',
        'data-relatedElement' => '#action',
        'data-confirmMessage' => $jsVarName,
    ]);
    echo $button;
    $this->Js->set($jsVarName, __d('atcmobile', '%s selected items?'));
    $this->Js->buffer("$('.bulk-process').on('click', Nodes.confirmProcess);");

    $this->end();
