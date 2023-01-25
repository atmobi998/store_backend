<?php

use Cake\Utility\Hash;
use Atcmobapp\Core\Status;

$this->assign('title', __d('atcmobile', 'Contents'));

$this->extend('Atcmobapp/Core./Common/admin_index');

$this->Atcmobapp->adminScript('Atcmobapp/Nodes.admin');

$this->Breadcrumbs
    ->add(__d('atcmobile', 'Content'), $this->getRequest()->getUri()->getPath());

if ($this->getRequest()->getQuery('type')):
    $this->Breadcrumbs->add($type->title, [
        'action' => 'index',
        'type' => $type->alias,
    ]);
endif;

$this->append('action-buttons');
    if (isset($type)):
        echo $this->Atcmobapp->adminAction(__d('atcmobile', 'New %s', $type->title), [
            'action' => 'add',
            $type->alias,
        ]);
    else:
        echo $this->Atcmobapp->adminAction(__d('atcmobile', 'Create content'), ['action' => 'create']);
    endif;
$this->end();

$this->append('search', $this->element('admin/nodes_search'));

$this->append('form-start', $this->Form->create(null, [
    'url' => ['action' => 'process'],
    'align' => 'inline',
]));

$this->start('table-heading');
echo $this->Html->tableHeaders([
    $this->Form->checkbox('checkAll', ['id' => 'NodesCheckAll']),
    $this->Paginator->sort('title', __d('atcmobile', 'Title')),
    $this->Paginator->sort('type', __d('atcmobile', 'Type')),
    $this->Paginator->sort('user_id', __d('atcmobile', 'User')),
    $this->Paginator->sort('publish_start', __d('atcmobile', 'Pub Date')),
    $this->Paginator->sort('status', __d('atcmobile', 'Status')),
    '',
]);
$this->end();

$this->append('table-body');
?>
    <?php foreach ($nodes as $node): ?>
        <tr>
            <td><?= $this->Form->checkbox('Nodes.' . $node->id . '.id',
                    ['class' => 'row-select', 'id' => 'Nodes' . $node->id . 'Id']) ?></td>
            <td>
                <span>
                <?php
                echo $this->Html->link($this->Text->truncate($node->title, 40),
                    Hash::merge($node->url->getArrayCopy(), [
                        'prefix' => false,
                    ]),
                    ['target' => '_blank', 'title' => $node->title]
                );
                ?>
                </span>

                <?php if ($node->promote == 1): ?>
                    <span class="badge badge-info"><?= __d('atcmobile', 'promoted') ?></span>
                <?php endif ?>

                <?php if ($node->status == Status::PREVIEW): ?>
                    <span class="badge badge-warning"><?= __d('atcmobile', 'preview') ?></span>
                <?php endif ?>
            </td>
            <td>
                <?php
                echo $this->Html->link($node->type, [
                    'action' => 'index',
                    '?' => [
                        'type' => $node->type,
                    ],
                ]);
                ?>
            </td>
            <td>
                <?= $node->user->username ?>
            </td>
            <td>
                <?= $this->Time->i18nFormat($node->publish_start) ?>
            </td>
            <td>
                <?php
                echo $this->element('Atcmobapp/Core.admin/toggle', [
                    'id' => $node->id,
                    'status' => (int)$node->status,
                ]);
                ?>
            </td>
            <td>
                <div class="item-actions">
                    <?php
                    echo $this->Atcmobapp->adminRowActions($node->id);

                    if ($this->getRequest()->getQuery('type')):
                        echo ' ' . $this->Atcmobapp->adminRowAction('', ['action' => 'move', $node->id, 'up'], [
                                'method' => 'post',
                                'icon' => $this->Theme->getIcon('move-up'),
                                'escapeTitle' => false,
                                'tooltip' => __d('atcmobile', 'Move up'),
                            ]);
                        echo ' ' . $this->Atcmobapp->adminRowAction('', ['action' => 'move', $node->id, 'down'], [
                                'method' => 'post',
                                'icon' => $this->Theme->getIcon('move-down'),
                                'escapeTitle' => false,
                                'tooltip' => __d('atcmobile', 'Move down'),
                            ]);
                    endif;

                    echo ' ' . $this->Atcmobapp->adminRowAction('', ['action' => 'edit', $node->id], [
                            'icon' => $this->Theme->getIcon('update'),
                            'escapeTitle' => false,
                            'tooltip' => __d('atcmobile', 'Edit this item'),
                        ]);
                    echo ' ' . $this->Atcmobapp->adminRowAction('', '#Nodes' . $node->id . 'Id', [
                            'icon' => $this->Theme->getIcon('copy'),
                            'escapeTitle' => false,
                            'tooltip' => __d('atcmobile', 'Create a copy'),
                            'rowAction' => 'copy',
                        ]);
                    echo ' ' . $this->Atcmobapp->adminRowAction('', '#Nodes' . $node->id . 'Id', [
                            'icon' => $this->Theme->getIcon('delete'),
                            'escapeTitle' => false,
                            'class' => 'delete',
                            'tooltip' => __d('atcmobile', 'Remove this item'),
                            'rowAction' => 'delete',
                        ], __d('atcmobile', 'Are you sure?'));
                    ?>
                </div>
            </td>
        </tr>
    <?php endforeach ?>
<?php
$this->end();

$this->start('bulk-action');
echo $this->Form->input('action', [
    'label' => __d('atcmobile', 'Bulk actions'),
    'class' => 'c-select',
    'options' => [
        'publish' => __d('atcmobile', 'Publish'),
        'unpublish' => __d('atcmobile', 'Unpublish'),
        'promote' => __d('atcmobile', 'Promote'),
        'unpromote' => __d('atcmobile', 'Unpromote'),
        'delete' => __d('atcmobile', 'Delete'),
        [
            'value' => 'copy',
            'text' => __d('atcmobile', 'Copy'),
            'hidden' => true,
        ],
    ],
    'empty' => 'Bulk actions',
]);

$jsVarName = uniqid('confirmMessage_');
echo $this->Form->button(__d('atcmobile', 'Apply'), [
    'type' => 'button',
    'class' => 'bulk-process btn-outline-primary',
    'data-relatedElement' => '#action',
    'data-confirmMessage' => $jsVarName,
    'escape' => true,
]);

$this->Js->set($jsVarName, __d('atcmobile', '%s selected items?'));
$this->Js->buffer("$('.bulk-process').on('click', Nodes.confirmProcess);");

$this->end();
