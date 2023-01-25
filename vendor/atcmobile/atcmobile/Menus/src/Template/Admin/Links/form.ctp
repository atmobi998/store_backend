<?php

$this->extend('Atcmobapp/Core./Common/admin_edit');
$this->Atcmobapp->adminScript('Atcmobapp/Menus.admin');

$this->Breadcrumbs->add(__d('atcmobile', 'Menus'), ['controller' => 'Menus', 'action' => 'index']);

if ($this->getRequest()->getParam('action') == 'add') {
    $this->Breadcrumbs->add(h($menu->title), [
                'action' => 'index',
                '?' => ['menu_id' => $menu->id],
            ])
        ->add(__d('atcmobile', 'Add'), $this->getRequest()->getRequestTarget());
    $formUrl = [
        'action' => 'add',
        $menu->id,
    ];
}

if ($this->getRequest()->getParam('action') == 'edit') {
    $this->Breadcrumbs->add(h($menu->title), [
            'action' => 'index',
            '?' => ['menu_id' => $menu->id],
        ])
        ->add($link->title, $this->getRequest()->getRequestTarget());
    $formUrl = [
        'action' => 'edit',
        '?' => [
            'menu_id' => $menu->id,
        ],
    ];
}

$this->append('form-start', $this->Form->create($link, [
    'url' => $formUrl,
    'class' => 'protected-form',
]));

//$inputDefaults = $this->Form->getTemplates();
//$inputClass = isset($inputDefaults['class']) ? $inputDefaults['class'] : null;

$this->append('tab-heading');
    echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Link'), '#link-basic');
    echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Misc.'), '#link-misc');
$this->end();

$this->append('tab-content');

    echo $this->Html->tabStart('link-basic');
        echo $this->Form->input('menu_id', [
            'selected' => $menu->id,
            'class' => 'c-select'
        ]);
        echo $this->Form->input('parent_id', [
            'title' => __d('atcmobile', 'Parent'),
            'options' => $parentLinks,
            'empty' => __d('atcmobile', '(no parent)'),
            'class' => 'c-select'
        ]);
        echo $this->Form->input('title', [
            'label' => __d('atcmobile', 'Title'),
        ]);

        $linkString = (string)$link->link;
        $linkOptions = [];
        if (preg_match('/(plugin:)|(controller:)|(action:)/', $linkString)) :
            $linkKeys = explode('/', $linkString);
            foreach ($linkKeys as $linkKey) :
                $linkOptions[] = [
                    'value' => $linkKey,
                    'text' => urldecode($linkKey),
                    'selected' => true,
                    'data-select2-tag' => "true",
                ];
            endforeach;
        else :
            if (!$link->isNew() && $linkString) :
                $linkOptions[] = [
                    'value' => $linkString,
                    'text' => urldecode($linkString),
                    'selected' => true,
                    'data-select2-tag' => "true",
                ];
            endif;
        endif;

        echo $this->Form->input('link', [
            'label' => __d('atcmobile', 'Link'),
            'linkChooser' => true,
            'class' => 'no-select2 link-chooser',
            'type' => 'select',
            'multiple' => true,
            'options' => $linkOptions,
        ]);

        echo $this->Html->tabEnd();

        echo $this->Html->tabStart('link-misc');
        echo $this->Form->input('description', [
            'label' => __d('atcmobile', 'Description'),
        ]);
        echo $this->Form->input('class', [
            'label' => __d('atcmobile', 'Class'),
        ]);
        echo $this->Form->input('rel', [
            'label' => __d('atcmobile', 'Rel'),
        ]);
        echo $this->Form->input('target', [
            'label' => __d('atcmobile', 'Target'),
        ]);
        echo $this->Form->input('params', [
            'label' => __d('atcmobile', 'Params'),
            'type' => 'stringlist',
        ]);
        echo $this->Html->tabEnd();

        $this->end();

        $this->start('panels');
        echo $this->Html->beginBox(__d('atcmobile', 'Publishing'));
        echo $this->element('Atcmobapp/Core.admin/buttons', [
            'type' => 'link',
            'cancelUrl' => [
                'action' => 'index',
                'menu_id' => $menu->id,
            ],
        ]);
        echo $this->element('Atcmobapp/Core.admin/publishable');
        echo $this->Html->endBox();

        echo $this->Html->beginBox(__d('atcmobile', 'Access control'));
        echo $this->Form->input('visibility_roles', [
            'class' => 'c-select',
            'options' => $roles,
            'multiple' => true,
            'label' => false,
        ]);
        echo $this->Html->endBox();
        $this->end();
