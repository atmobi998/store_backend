<?php

$this->extend('Atcmobapp/Core./Common/admin_index');

$this->assign('title', __d('atcmobile', 'Plugins'));

$this->Breadcrumbs->add(__d('atcmobile', 'Extensions'), $this->getRequest()->getUri()->getPath())
    ->add(__d('atcmobile', 'Plugins'), $this->getRequest()->getUri()->getPath());

$this->start('action-buttons');
echo $this->Atcmobapp->adminAction(__d('atcmobile', 'Upload'), ['action' => 'add']);
$this->end();

$this->append('table-heading');
    $tableHeaders = $this->Html->tableHeaders([
        '',
        __d('atcmobile', 'Alias'),
        __d('atcmobile', 'Name'),
        __d('atcmobile', 'Description'),
        __d('atcmobile', 'Active'),
        __d('atcmobile', 'Actions'),
    ]);
    echo $tableHeaders;
    $this->end();

    $this->append('table-body');

    $rows = [];
    foreach ($plugins as $pluginAlias => $pluginData) :
        $toggleText = $pluginData['active'] ? __d('atcmobile', 'Deactivate') : __d('atcmobile', 'Activate');
        $statusIcon = $this->Html->status($pluginData['active']);

        $actions = [];
        $queryString = ['name' => $pluginAlias];
        if (!in_array($pluginAlias, $bundledPlugins) && !in_array($pluginAlias, $corePlugins)) :
            $icon = $pluginData['active'] ? $this->Theme->getIcon('power-off') : $this->Theme->getIcon('power-on');
            $actions[] = $this->Atcmobapp->adminRowAction(
                '',
                ['action' => 'toggle', '?' => $queryString],
                ['icon' => $icon, 'escapeTitle' => false, 'tooltip' => $toggleText, 'method' => 'post']
            );
            $actions[] = $this->Atcmobapp->adminRowAction(
                '',
                ['action' => 'delete', '?' => $queryString],
                ['icon' => $this->Theme->getIcon('delete'), 'escapeTitle' => false, 'tooltip' => __d('atcmobile', 'Delete')],
                __d('atcmobile', 'Are you sure?')
            );
        endif;

        if ($pluginData['active'] &&
            !in_array($pluginAlias, $bundledPlugins) &&
            !in_array($pluginAlias, $corePlugins)
        ) {
            $actions[] = $this->Atcmobapp->adminRowAction(
                '',
                ['action' => 'moveup', '?' => $queryString],
                ['icon' => $this->Theme->getIcon('move-up'), 'escapeTitle' => false, 'tooltip' => __d('atcmobile', 'Move up'), 'method' => 'post'],
                __d('atcmobile', 'Are you sure?')
            );

            $actions[] = $this->Atcmobapp->adminRowAction('', ['action' => 'movedown', '?' => $queryString], [
                    'icon' => $this->Theme->getIcon('move-down'),
                    'escapeTitle' => false,
                    'tooltip' => __d('atcmobile', 'Move down'),
                    'method' => 'post',
                ], __d('atcmobile', 'Are you sure?'));
        }

        if ($pluginData['needMigration']) {
            $actions[] = $this->Atcmobapp->adminRowAction(__d('atcmobile', 'Migrate'), [
                'action' => 'migrate',
                '?' => $queryString,
            ], [], __d('atcmobile', 'Are you sure?'));
        }

        $actions = $this->Html->div('item-actions', implode(' ', $actions));

        $rows[] = [
            '',
            $pluginAlias,
            $pluginData['name'],
            !empty($pluginData['description']) ? $pluginData['description'] : '',
            $statusIcon,
            $actions,
        ];
    endforeach;

    echo $this->Html->tableCells($rows);
    $this->end();
