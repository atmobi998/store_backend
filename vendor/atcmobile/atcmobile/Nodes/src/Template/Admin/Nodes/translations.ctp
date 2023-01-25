<?php

$this->append('action-buttons');
    echo $this->Html->link(__d('atcmobile', 'Translate in a new language'), [
        'controller' => 'Languages',
        'action' => 'select',
        'nodes',
        'translate',
        $node['Node']['id'],
    ]);
    $this->end();

    if (count($translations) == 0) :
        echo __d('atcmobile', 'No translations available.');

        return;
    endif;

    $this->append('table-heading');
    $tableHeaders = $this->Html->tableHeaders([
        '',
        __d('atcmobile', 'Title'),
        __d('atcmobile', 'Locale'),
        __d('atcmobile', 'Actions'),
    ]);
    echo $tableHeaders;
    $this->end();

    $this->append('table-footer');
    echo $tableHeaders;
    $this->end();

    $this->append('table-body');

    $rows = [];
    foreach ($translations as $translation) :
        $actions = $this->Html->link(__d('atcmobile', 'Edit'), [
            'action' => 'translate',
            $id,
            'locale' => $translation[$runtimeModelAlias]['locale'],
        ]);
        $actions .= ' ' . $this->Form->postLink(__d('atcmobile', 'Delete'), [
            'action' => 'delete_translation',
            $translation[$runtimeModelAlias]['locale'],
            $id
        ], null, __d('atcmobile', 'Are you sure?'));
        $rows[] = [
            '',
            $translation[$runtimeModelAlias]['content'],
            $translation[$runtimeModelAlias]['locale'],
            $actions,
        ];
    endforeach;

    echo $this->Html->tableCells($rows);
    $this->end();
