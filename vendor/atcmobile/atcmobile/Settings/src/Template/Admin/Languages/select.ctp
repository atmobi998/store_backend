<?php

$this->extend('/Common/admin_index');

$this->Breadcrumbs
    ->add(__d('atcmobile', 'Settings'), [
        'plugin' => 'Atcmobapp/Settings',
        'controller' => 'Settings',
        'action' => 'index',
    ])
    ->add(__d('atcmobile', 'Languages'), [
        'plugin' => 'Atcmobapp/Settings',
        'controller' => 'Languages',
        'action' => 'index'
    ]);

$this->append('main');
    $html = null;
foreach ($languages as $language) :
    $title = $language->title . ' (' . $language->native . ')';
    $link = $this->Html->link($title, [
        'plugin' => 'Atcmobapp/Translate',
        'controller' => 'Translate',
        'action' => 'edit',
        '?' => [
            'id' => $id,
            'model' => $modelAlias,
            'locale' => $language->alias,
        ],
    ]);
    $html .= '<li>' . $link . '</li>';
endforeach;
    echo $this->Html->div(
        $this->Theme->getCssClass('columnFull'),
        $this->Html->tag('ul', $html)
    );
    $this->end();
