<?php

$this->Atcmobapp->adminScript('Atcmobapp/Contacts.admin');

$this->extend('Atcmobapp/Core./Common/admin_index');

$this->Breadcrumbs->add(__d('atcmobile', 'Contacts'), ['controller' => 'Contacts', 'action' => 'index']);

$status = $this->getRequest()->getQuery('status');

if (isset($status)) {
    $this->Breadcrumbs->add(__d('atcmobile', 'Messages'), ['action' => 'index']);
    if ($status == '1') {
        $this->Breadcrumbs->add(__d('atcmobile', 'Read'), $this->getRequest()->getUri()->getPath());
        $this->assign('title', __d('atcmobile', 'Messages: Read'));
    } else {
        $this->Breadcrumbs->add(__d('atcmobile', 'Unread'), $this->getRequest()->getUri()->getPath());
        $this->assign('title', __d('atcmobile', 'Messages: Unread'));
    }
} else {
    $this->Breadcrumbs->add(__d('atcmobile', 'Messages'), $this->getRequest()->getUri()->getPath());
}

$this->append('table-footer', $this->element('admin/modal', [
        'id' => 'comment-modal',
    ]));

$this->append('action-buttons');
echo $this->Atcmobapp->adminAction(__d('atcmobile', 'Unread'), [
    'action' => 'index',
    '?' => [
        'status' => '0',
    ],
]);
echo $this->Atcmobapp->adminAction(__d('atcmobile', 'Read'), [
    'action' => 'index',
    '?' => [
        'status' => '1',
    ],
]);
$this->end();

$this->append('form-start', $this->Form->create(null, [
    'url' => ['action' => 'process'],
    'align' => 'inline',
]));

$this->start('table-heading');
$tableHeaders = $this->Html->tableHeaders([
    $this->Form->checkbox('checkAll', ['id' => 'MessagesCheckAll']),
    $this->Paginator->sort('contact_id', __d('atcmobile', 'Contact')),
    $this->Paginator->sort('name', __d('atcmobile', 'Name')),
    $this->Paginator->sort('email', __d('atcmobile', 'Email')),
    $this->Paginator->sort('title', __d('atcmobile', 'Title')),
    $this->Paginator->sort('created', __d('atcmobile', 'Created')),
    __d('atcmobile', 'Actions'),
]);
echo $tableHeaders;
$this->end();

$this->append('table-body');
$commentIcon = $this->Html->icon($this->Theme->getIcon('comment'));
$rows = [];
foreach ($messages as $message) {
    $actions = [];

    $actions[] = $this->Atcmobapp->adminRowAction('', ['action' => 'view', $message->id], [
        'icon' => $this->Theme->geticon('read'),
        'escapeTitle' => false,
        'tooltip' => __d('atcmobile', 'View this item'),
    ]);
    $actions[] = $this->Atcmobapp->adminRowAction('', ['action' => 'edit', $message->id], [
        'icon' => $this->Theme->getIcon('update'),
        'escapeTitle' => false,
        'tooltip' => __d('atcmobile', 'Edit this item'),
    ]);
    $actions[] = $this->Atcmobapp->adminRowAction('', '#Message' . $message->id . 'Id', [
        'icon' => $this->Theme->getIcon('delete'),
        'escapeTitle' => false,
        'class' => 'delete',
        'tooltip' => __d('atcmobile', 'Remove this item'),
        'rowAction' => 'delete',
    ], __d('atcmobile', 'Are you sure?'));
    $actions[] = $this->Atcmobapp->adminRowActions($message->id);

    $actions = $this->Html->div('item-actions', implode(' ', $actions));

    $rows[] = [
        $this->Form->checkbox('Messages.' . $message->id . '.id', [
            'class' => 'row-select',
            'id' => 'Messages'. $message->id . 'Id',
        ]),
        h($message->contact->title),
        h($message->name),
        h($message->email),
        $commentIcon . ' ' . $this->Html->link($message->title, '#', [
            'class' => 'comment-view',
            'data-target' => '#comment-modal',
            'data-title' => h($message->title),
            'data-content' => h($message->body),
        ]),
        $this->Time->i18nFormat($message->created),
        $actions,
    ];
}
echo $this->Html->tableCells($rows);
$this->end();

$this->start('bulk-action');
echo $this->Form->input('action', [
    'label' => __d('atcmobile', 'Bulk action'),
    'class' => 'c-select',
    'options' => [
        'read' => __d('atcmobile', 'Mark as read'),
        'unread' => __d('atcmobile', 'Mark as unread'),
        'delete' => __d('atcmobile', 'Delete'),
    ],
    'empty' => __d('atcmobile', 'Bulk action'),
]);
echo $this->Form->button(__d('atcmobile', 'Apply'), [
    'type' => 'submit',
    'value' => 'submit',
    'class' => 'bulk-process btn-outline-primary',
]);
$this->end();
