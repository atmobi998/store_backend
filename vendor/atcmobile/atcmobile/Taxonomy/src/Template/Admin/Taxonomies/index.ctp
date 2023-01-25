<?php

$this->assign('title', __d('atcmobile', 'Vocabulary: %s', $vocabulary->title));

$this->extend('Atcmobapp/Core./Common/admin_index');

$this->Breadcrumbs->add(
    __d('atcmobile', 'Content'),
    ['plugin' => 'Atcmobapp/Nodes', 'controller' => 'Nodes', 'action' => 'index']
)
    ->add(
        __d('atcmobile', 'Vocabularies'),
        ['plugin' => 'Atcmobapp/Taxonomy', 'controller' => 'Vocabularies', 'action' => 'index']
    )
    ->add(h($vocabulary->title), $this->getRequest()->getRequestTarget());

$this->append('action-buttons');
echo $this->Atcmobapp->adminAction(__d('atcmobile', 'Create term'), [
    'controller' => 'Terms',
    'action' => 'add',
    'vocabulary_id' => $vocabulary->id,
]);
$this->end();

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

foreach ($taxonomies as $taxonomy) :
    $term = $taxonomy->term;

    $actions = [];
    $actions[] = $this->Atcmobapp->adminRowActions($term->id);
    $actions[] = $this->Atcmobapp->adminRowAction('', [
        'action' => 'moveUp',
        $taxonomy->id,
        $vocabulary->id,
    ], [
        'icon' => $this->Theme->getIcon('move-up'),
        'escapeTitle' => false,
        'tooltip' => __d('atcmobile', 'Move up'),
        'method' => 'post',
    ]);
    $actions[] = $this->Atcmobapp->adminRowAction('', [
        'action' => 'moveDown',
        $taxonomy->id,
        $vocabulary->id,
    ], [
        'icon' => $this->Theme->getIcon('move-down'),
        'escapeTitle' => false,
        'tooltip' => __d('atcmobile', 'Move down'),
        'method' => 'post',
    ]);
    $actions[] = $this->Atcmobapp->adminRowAction('', [
        'controller' => 'Terms',
        'action' => 'edit',
        $term->id,
        'vocabulary_id' => $vocabulary->id,
    ], [
        'icon' => $this->Theme->getIcon('update'),
        'escapeTitle' => false,
        'tooltip' => __d('atcmobile', 'Edit this item'),
    ]);
    $actions[] = $this->Atcmobapp->adminRowAction('', [
        'controller' => 'Taxonomies',
        'action' => 'delete',
        $taxonomy->id,
        'vocabulary_id' => $vocabulary->id,
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

    if (!empty($taxonomy->indent)) :
        $titleCol = str_repeat('&emsp;', $taxonomy->indent) . $titleCol;
    endif;

    // Build link list
    $typeLinks = $this->Taxonomies->generateTypeLinks($vocabulary->types, $term);
    if (!empty($typeLinks)) {
        $titleCol .= $this->Html->tag('small', $typeLinks);
    }

    $rows[] = [
        $titleCol,
        $term->slug,
        $actions,
    ];
endforeach;
echo $this->Html->tableCells($rows);
$this->end();
