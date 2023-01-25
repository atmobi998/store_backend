<?php

use Cake\Utility\Inflector;

$this->extend('/Common/admin_edit');
$this->assign('title', sprintf(__d('atcmobile', 'Translate content: %s (%s)'), $language->title, $language->native ?: $language->alias));
$this->set('className', 'translate');

$crumbLabel = $model == 'Nodes' ? __d('atcmobile', 'Content') : Inflector::pluralize($model);

$this->Breadcrumbs
    ->add($crumbLabel)
    ->add($entity->get($displayField))
    ->add(
        __d('atcmobile', 'Translations'),
        [
            'plugin' => 'Atcmobapp/Translate',
            'controller' => 'Translate',
            'action' => 'index',
            '?' => [
                'id' => $id,
                'model' => $modelAlias,
            ],
        ]
    )
    ->add(__d('atcmobile', 'Translate (%s)', $language->title), $this->getRequest()->getRequestTarget());

$this->append('form-start', $this->Form->create($entity, [
    'url' => [
        'plugin' => 'Atcmobapp/Translate',
        'controller' => 'Translate',
        'action' => 'edit',
        $id,
        '?' => [
            'id' => $entity->id,
            'model' => $modelAlias,
            'locale' => $locale,
        ],
    ]
]));

$this->append('tab-heading');
    echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Translate'), '#translate-main');
    echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Original'), '#translate-original');
$this->end();

$this->append('tab-content');

    echo $this->Html->tabStart('translate-main');
foreach ($fields as $field) :
    $name = '_translations.' . $locale . '.' . $field;
    echo $this->Form->input($name, [
        'default' => $entity->get($field),
    ]);
endforeach;
    echo $this->Html->tabEnd();

    echo $this->Html->tabStart('translate-original');
foreach ($fields as $field) :
    $name = '_original.' . $field;
    echo $this->Form->input($name, [
        'value' => $entity->$field,
        'readonly' => true,
    ]);
endforeach;
    echo $this->Html->tabEnd();

$this->end();

$this->start('panels');
    echo $this->Html->beginBox(__d('atcmobile', 'Publishing'));

        echo $this->element('admin/buttons', [
            'cancelUrl' => [
                'action' => 'index',
                '?' => [
                    'id' => $this->getRequest()->query('id'),
                    'model' => urldecode($this->getRequest()->query('model')),
                ],
            ],
        ]);

    echo $this->Html->endBox();
$this->end();
