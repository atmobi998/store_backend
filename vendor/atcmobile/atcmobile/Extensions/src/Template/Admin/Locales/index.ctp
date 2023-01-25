<?php

use Cake\Core\Configure;

$this->extend('Atcmobapp/Core./Common/admin_index');

$this->assign('title', __d('atcmobile', 'Locales'));

$this->Breadcrumbs
    ->add(__d('atcmobile', 'Extensions'), ['plugin' => 'Atcmobapp/Extensions', 'controller' => 'Plugins', 'action' => 'index'])
    ->add(__d('atcmobile', 'Locales'), $this->getRequest()->getUri()->getPath());

$this->append('action-buttons');
    echo $this->Atcmobapp->adminAction(
        __d('atcmobile', 'Upload'),
        ['action' => 'add']
    );
    $this->end();

    $this->start('table-heading');
    $tableHeaders = $this->Html->tableHeaders([
        '',
        __d('atcmobile', 'Locale'),
        __d('atcmobile', 'Name'),
        __d('atcmobile', 'Default'),
        __d('atcmobile', 'Actions'),
    ]);
    echo $tableHeaders;
    $this->end();

    $this->append('table-body');
    $rows = [];
    $vendorDir = ROOT . DS . 'vendor' . DS . 'atcmobile' . DS . 'locale' . DS;
    $siteLocale = Configure::read('Site.locale');
    foreach ($locales as $locale => $data) :
        $actions = [];

        if ($locale == $siteLocale) {
            $status = $this->Html->status(1);
            $actions[] = $this->Atcmobapp->adminRowAction(
                '',
                ['action' => 'deactivate', $locale],
                [
                    'icon' => $this->Theme->getIcon('power-off'),
                    'escapeTitle' => false,
                    'tooltip' => __d('atcmobile', 'Deactivate'),
                    'method' => 'post'
                ]
            );
        } else {
            $status = $this->Html->status(0);
            $actions[] = $this->Atcmobapp->adminRowAction(
                '',
                ['action' => 'activate', $locale],
                [
                    'icon' => $this->Theme->getIcon('power-on'),
                    'escapeTitle' => false,
                    'tooltip' => __d('atcmobile', 'Activate'),
                    'method' => 'post'
                ]
            );
        }

        $actions[] = $this->Atcmobapp->adminRowAction(
            '',
            ['action' => 'edit', $locale],
            [
                'icon' => $this->Theme->getIcon('update'),
                'escapeTitle' => false,
                'tooltip' => __d('atcmobile', 'Edit this item')
            ]
        );

        if (strpos($data['path'], $vendorDir) !== 0) :
            $actions[] = $this->Atcmobapp->adminRowAction(
                '',
                ['action' => 'delete', $locale],
                [
                    'icon' => $this->Theme->getIcon('delete'),
                    'tooltip' => __d('atcmobile', 'Remove this item'),
                ],
                __d('atcmobile', 'Are you sure?')
            );
        endif;
        $actions = $this->Html->div('item-actions', implode(' ', $actions));

        $rows[] = [
            '',
            $locale,
            $data['name'],
            $status,
            $actions,
        ];
    endforeach;

    usort($rows, function ($a, $b) {
        return strcmp($a[3], $b[3]);
    });

    echo $this->Html->tableCells($rows);
    $this->end();
