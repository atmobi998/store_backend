<?php

$this->extend('Atcmobapp/Core./Common/admin_index');

$this->Atcmobapp->adminScript('Atcmobapp/Acl.acl_permissions');

$this->Breadcrumbs
    ->add(__d('atcmobile', 'Users'), ['plugin' => 'Atcmobapp/Users', 'controller' => 'Users', 'action' => 'index'])
    ->add(__d('atcmobile', 'Permissions'), [
        'plugin' => 'Atcmobapp/Acl', 'controller' => 'Permissions',
    ])
    ->add(__d('atcmobile', 'Actions'), ['plugin' => 'Atcmobapp/Acl', 'controller' => 'Actions', 'action' => 'index', 'permission' => 1]);

$this->append('action-buttons');
    $toolsButton = $this->Html->link(
        __d('atcmobile', 'Tools'),
        '#',
        [
            'button' => 'outline-secondary',
            'class' => 'btn-sm dropdown-toggle',
            'data-toggle' => 'dropdown',
            'escape' => false
        ]
    );

    $generateUrl = [
        'plugin' => 'Atcmobapp/Acl',
        'controller' => 'Actions',
        'action' => 'generate',
        'permissions' => 1
    ];
    $out = $this->Atcmobapp->adminAction(
        __d('atcmobile', 'Generate'),
        $generateUrl,
        [
            'button' => false,
            'list' => true,
            'method' => 'post',
            'class' => 'dropdown-item',
            'tooltip' => [
                'data-title' => __d('atcmobile', 'Create new actions (no removal)'),
                'data-placement' => 'left',
            ],
        ]
    );
    $out .= $this->Atcmobapp->adminAction(
        __d('atcmobile', 'Synchronize'),
        $generateUrl + ['sync' => 1],
        [
            'button' => false,
            'list' => true,
            'method' => 'post',
            'class' => 'dropdown-item',
            'tooltip' => [
                'data-title' => __d('atcmobile', 'Create new & remove orphaned actions'),
                'data-placement' => 'left',
            ],
        ]
    );
    echo $this->Html->div(
        'btn-group',
        $toolsButton .
        $this->Html->tag('ul', $out, [
            'class' => 'dropdown-menu dropdown-menu-right',
        ])
    );
    $this->end();

    $this->set('tableClass', 'table permission-table');
    $this->start('table-heading');
    $tableHeaders = $this->Html->tableHeaders([
        __d('atcmobile', 'Id'),
        __d('atcmobile', 'Alias'),
        __d('atcmobile', 'Actions'),
    ]);
    echo $this->Html->tag('thead', $tableHeaders);
    $this->end();

    $this->append('table-body');
    $currentController = '';
    $icon = '<i class="icon-none float-right"></i>';
    foreach ($acos as $aco) {
        $id = $aco->id;
        $alias = $aco->alias;
        $class = '';
        if (substr($alias, 0, 1) == '_') {
            $level = 1;
            $class .= 'level-' . $level;
            $oddOptions = ['class' => 'hidden controller-' . $currentController];
            $evenOptions = ['class' => 'hidden controller-' . $currentController];
            $alias = substr_replace($alias, '', 0, 1);
        } else {
            $level = 0;
            $class .= ' controller';
            if ($aco->children > 0) {
                $class .= ' perm-expand';
            }
            $oddOptions = [];
            $evenOptions = [];
            $currentController = $alias;
        }

        $actions = [];
        $actions[] = $this->Atcmobapp->adminRowAction(
            '',
            ['action' => 'move', $id, 'up'],
            [
                'icon' => $this->Theme->getIcon('move-up'),
                'escapeTitle' => false,
                'tooltip' => __d('atcmobile', 'Move up')
            ]
        );
        $actions[] = $this->Atcmobapp->adminRowAction(
            '',
            ['action' => 'move', $id, 'down'],
            [
                'icon' => $this->Theme->getIcon('move-down'),
                'escapeTitle' => false,
                'tooltip' => __d('atcmobile', 'Move down')
            ]
        );

        $actions[] = $this->Atcmobapp->adminRowAction(
            '',
            ['action' => 'edit', $id],
            [
                'icon' => $this->Theme->getIcon('update'),
                'escapeTitle' => false,
                'tooltip' => __d('atcmobile', 'Edit this item')
            ]
        );
        $actions[] = $this->Atcmobapp->adminRowAction(
            '',
            ['action' => 'delete', $id],
            [
                'icon' => $this->Theme->getIcon('delete'),
                'tooltip' => __d('atcmobile', 'Remove this item'),
                'escapeTitle' => false,
                'escape' => true,
            ],
            __d('atcmobile', 'Are you sure?')
        );

        $actions = $this->Html->div('item-actions', implode(' ', $actions));
        $row = [
            $id,
            $this->Html->div(trim($class), $alias . $icon, [
                'data-id' => $id,
                'data-alias' => $alias,
                'data-level' => $level,
            ]),
            $actions,
        ];

        echo $this->Html->tableCells($row, $oddOptions, $evenOptions);
    }
    echo $this->Html->tag('thead', $tableHeaders);
    $this->end();

    $this->Js->buffer('AclPermissions.documentReady();');
