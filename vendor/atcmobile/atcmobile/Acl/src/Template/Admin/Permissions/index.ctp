<?php

$tabContentClass = $this->Theme->getCssClass('tabContentClass');

$this->extend('Atcmobapp/Core./Common/admin_index');

$this->Atcmobapp->adminScript('Atcmobapp/Acl.acl_permissions');

$this->Breadcrumbs->add(
    __d('atcmobile', 'Users'),
    ['plugin' => 'Atcmobapp/Users', 'controller' => 'Users', 'action' => 'index']
)
    ->add(__d('atcmobile', 'Permissions'), $this->getRequest()->getUri()->getPath());

$this->append('action-buttons');
$toolsButton = $this->Html->link(__d('atcmobile', 'Tools'), '#', [
        'button' => 'outline-secondary btn-sm',
        'class' => 'dropdown-toggle',
        'data-toggle' => 'dropdown',
        'escape' => false,
    ]);

$generateUrl = [
    'plugin' => 'Atcmobapp/Acl',
    'controller' => 'Actions',
    'action' => 'generate',
    'permissions' => 1,
];
$out = $this->Atcmobapp->adminAction(__d('atcmobile', 'Generate'), $generateUrl, [
        'button' => false,
        'list' => true,
        'method' => 'post',
        'class' => 'dropdown-item',
        'tooltip' => [
            'data-title' => __d('atcmobile', 'Create new actions (no removal)'),
            'data-placement' => 'left',
        ],
    ]);
$out .= $this->Atcmobapp->adminAction(__d('atcmobile', 'Synchronize'), $generateUrl + ['sync' => 1], [
        'button' => false,
        'list' => true,
        'method' => 'post',
        'class' => 'dropdown-item',
        'tooltip' => [
            'data-title' => __d('atcmobile', 'Create new & remove orphaned actions'),
            'data-placement' => 'left',
        ],
    ]);
echo $this->Html->div('btn-group', $toolsButton . $this->Html->tag('ul', $out, [
    'class' => 'dropdown-menu dropdown-menu-right',
]));

echo $this->Atcmobapp->adminAction(
    __d('atcmobile', 'Edit Actions'),
    ['controller' => 'Actions', 'action' => 'index', 'permissions' => 1]
);
$this->end();

$this->Js->buffer('AclPermissions.tabSwitcher();');

?>
<div class="<?= $this->Theme->getCssClass('row') ?>">
    <div class="<?= $this->Theme->getCssClass('columnFull') ?>">

        <ul id="permissions-tab" class="nav nav-tabs">
        <?php
            echo $this->Atcmobapp->adminTabs();
        ?>
        </ul>

        <div class="<?= $tabContentClass ?>">
            <?= $this->Atcmobapp->adminTabs() ?>
        </div>

    </div>
</div>
