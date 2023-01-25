<?php

if (isset($vocabulary)) :
    $title = __d('atcmobile', 'Vocabulary: %s', $vocabulary->title);
else :
    $title = __d('atcmobile', 'Terms');
endif;
$this->assign('title', $title);

$this->extend('Atcmobapp/Core./Common/admin_index');

$this->Breadcrumbs
    ->add(__d('atcmobile', 'Content'), [
        'plugin' => 'Atcmobapp/Nodes',
        'controller' => 'Nodes',
        'action' => 'index',
    ])
    ->add(__d('atcmobile', 'Vocabularies'), [
        'plugin' => 'Atcmobapp/Taxonomy',
        'controller' => 'Vocabularies',
        'action' => 'index',
    ])
    ->add(__d('atcmobile', 'Terms'), [
        'plugin' => 'Atcmobapp/Taxonomy',
        'controller' => 'Terms',
        'action' => 'index',
    ]);

$this->set('showActions', false);

$this->start('table-heading');
$tableHeaders = $this->Html->tableHeaders([
    __d('atcmobile', 'Title'),
    __d('atcmobile', 'Slug'),
    __d('atcmobile', 'Actions'),
]);
echo $tableHeaders;
$this->end();

$this->append('table-body');
$rows = [];

foreach ($terms as $term) :
    $actions = [];
    $actions[] = $this->Atcmobapp->adminRowActions($term->id);
    $actions[] = $this->Atcmobapp->adminRowAction('', [
        'action' => 'edit', $term->id,
    ], [
        'icon' => $this->Theme->getIcon('update'),
        'escapeTitle' => false,
        'tooltip' => __d('atcmobile', 'Edit this item'),
    ]);
    $actions[] = $this->Atcmobapp->adminRowAction('', [
        'action' => 'delete', $term->id,
    ], [
        'icon' => $this->Theme->getIcon('delete'),
        'escapeTitle' => false,
        'tooltip' => __d('atcmobile', 'Remove this item'),
    ], __d('atcmobile', 'Are you sure?'));
    $actions = $this->Html->div('item-actions', implode(' ', $actions));

    // Title Column
    $titleCol = $term->title;
    if (isset($defaultType['alias'])) {
        $titleCol = $this->Html->link($term->title, [
            'prefix' => false,
            'plugin' => 'Atcmobapp/Nodes',
            'controller' => 'Nodes',
            'action' => 'term',
            'type' => $defaultType->alias,
            'term' => $term->slug,
        ], [
            'target' => '_blank',
        ]);
    }

    if (!empty($term->indent)) :
        $titleCol = str_repeat('&emsp;', $term->indent) . $titleCol;
    endif;

    // Build link list
    $vocabList = [];
    foreach ($term->taxonomies as $taxonomy) :
        $vocabList[] = $taxonomy->vocabulary->title;
    endforeach;
    if (!empty($vocabList)) :
        $titleCol .= sprintf('&nbsp;(%s)', $this->Html->tag('small', implode(', ', $vocabList)));
    endif;

    $rows[] = [
        $titleCol,
        $term->slug,
        $actions,
    ];
endforeach;
echo $this->Html->tableCells($rows);
$this->end();
