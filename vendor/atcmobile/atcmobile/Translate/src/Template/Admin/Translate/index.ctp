<?php

use Cake\Core\Configure;
use Cake\Utility\Inflector;

$this->extend('Atcmobapp/Core./Common/admin_index');

$plugin = 'Atcmobapp/Nodes';
$controller = 'Nodes';
$modelPath = $this->getRequest()->query('model');
list($plugin, $model) = pluginSplit($modelPath);
$controller = $model;

$crumbLabel = $model == 'Nodes' ? __d('atcmobile', 'Content') : Inflector::pluralize($model);

$this->Breadcrumbs
    ->add(
        $crumbLabel,
        [
            'plugin' => Inflector::underscore($plugin),
            'controller' => Inflector::underscore($controller),
            'action' => 'index',
        ]
    )
    ->add(
        $record->get($displayField),
        [
            'plugin' => Inflector::underscore($plugin),
            'controller' =>  Inflector::underscore($controller),
            'action' => 'edit',
            $record->id,
        ]
    )
    ->add(__d('atcmobile', 'Translations'), $this->getRequest()->getRequestTarget());

$this->start('action-buttons');
    $translateButton = $this->Html->link(
        __d('atcmobile', 'Translate in a new language'),
        [
            'plugin' => 'Atcmobapp/Settings',
            'controller' => 'Languages',
            'action' => 'select',
            '?' => [
                'id' => $record->id,
                'model' => $modelAlias,
            ],
        ],
        [
            'button' => 'outline-secondary',
            'class' => 'btn-sm dropdown-toggle',
            'data-toggle' => 'dropdown',
        ]
    );
    if (!empty($languages)) :
        $out = null;
        foreach ($languages as $languageAlias => $languageDisplay) :
            if ($languageAlias == Configure::read('App.defaultLocale')) :
                continue;
            endif;
            $out .= $this->Atcmobapp->adminAction($languageDisplay, [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Translate',
                'controller' => 'Translate',
                'action' => 'edit',
                '?' => [
                    'id' => $id,
                    'model' => $modelAlias,
                    'locale' => $languageAlias,
                ],
            ], [
                'button' => false,
                'list' => true,
                'class' => 'dropdown-item',
            ]);
        endforeach;
        echo $this->Html->div(
            'btn-group',
            $translateButton .
            $this->Html->tag('ul', $out, ['class' => 'dropdown-menu'])
        );
    endif;
    $this->end();

    if (count($translations->_translations) == 0) :
        echo $this->Html->para(null, __d('atcmobile', 'No translations available.'));

        return;
    endif;

    $this->append('table-heading');
    $tableHeaders = $this->Html->tableHeaders([
        '',
        __d('atcmobile', 'Original'),
        __d('atcmobile', 'Title'),
        __d('atcmobile', 'Locale'),
        __d('atcmobile', 'Actions'),
    ]);
    echo $tableHeaders;
    $this->end();

    $this->append('table-body');
    $rows = [];
    foreach ($translations->_translations as $locale => $entity) :
        $actions = [];
        $actions[] = $this->Atcmobapp->adminRowAction('', [
            'action' => 'edit',
            '?' => [
                'id' => $id,
                'model' => $modelAlias,
                'locale' => $locale,
            ],
        ], [
            'icon' => $this->Theme->getIcon('update'),
            'tooltip' => __d('atcmobile', 'Edit this item'),
        ]);
        $actions[] = $this->Atcmobapp->adminRowAction('', [
            'action' => 'delete',
            $id,
            urlencode($modelAlias),
            $locale,
        ], [
            'icon' => $this->Theme->getIcon('delete'),
            'tooltip' => __d('atcmobile', 'Remove this item'),
            'method' => 'post',
        ], __d('atcmobile', 'Are you sure?'));

        $actions = $this->Html->div('item-actions', implode(' ', $actions));
        $rows[] = [
            '',
            $record->title,
            $entity->title,
            $locale,
            $actions,
        ];
    endforeach;

    echo $this->Html->tableCells($rows);
    $this->end();
