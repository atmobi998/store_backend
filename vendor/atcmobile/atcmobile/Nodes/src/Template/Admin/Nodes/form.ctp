<?php

use Cake\Routing\Router;

$this->extend('Atcmobapp/Core./Common/admin_edit');
$this->Atcmobapp->adminScript(['Atcmobapp/Nodes.admin.js']);

$this->Breadcrumbs->add(__d('atcmobile', 'Content'), ['action' => 'index']);

if ($this->getRequest()->getParam('action') == 'add') :
    $this->assign('title', __d('atcmobile', 'Create content: %s', $type->title));

    $this->Breadcrumbs->add(__d('atcmobile', 'Create'), ['action' => 'create'])
        ->add(h($type->title), $this->getRequest()->getRequestTarget());
endif;

if ($this->getRequest()->getParam('action') == 'edit') :
    $this->assign('title', __d('atcmobile', 'Edit %s: %s', $node->type, $node->title));

    $this->Breadcrumbs
        ->add(h($type->title), [
            'action' => 'index',
            '?' => ['type' => $type->alias],
        ])
        ->add(h($node->title), $this->getRequest()->getRequestTarget(), [
            'innerAttrs' => [
                'title' => h($node->title),
            ],
        ]);
endif;

$this->append('form-start', $this->Form->create($node, [
    'class' => 'protected-form',
]));

$this->start('tab-heading');
    echo $this->Atcmobapp->adminTab(__d('atcmobile', h($type->title)), '#node-main');
$this->end();

$this->start('tab-content');
    echo $this->Html->tabStart('node-main');
        echo $this->Form->input('id');
        echo $this->Form->input('title', [
            'label' => false,
            'placeholder' => __d('atcmobile', '%s title', h($type->title)),
            'data-slug' => '#slug',
            'data-slug-editable' => true,
            'data-slug-edit-class' => 'btn btn-outline-secondary',
        ]);
        echo $this->Form->input('slug', [
            'class' => 'slug',
            'label' => __d('atcmobile', 'Permalink'),
            'prepend' => str_replace('_placeholder', '', $this->Url->build([
                'prefix' => false,
                'action' => 'view',
                'type' => $type->alias,
                'slug' => '_placeholder'
            ], ['fullbase' => true]))
        ]);
        echo $this->Form->input('body', [
            'label' => __d('atcmobile', 'Body'),
            'id' => 'NodeBody',
            'class' => !$type->format_use_wysiwyg ? 'no-wysiwyg' : ''
        ]);
        echo $this->Form->input('excerpt', [
            'label' => __d('atcmobile', 'Excerpt'),
            'id' => 'NodeExcerpt',
        ]);
        echo $this->Html->tabEnd();
        $this->end();

        $this->start('panels');
        $username = isset($node->user->username) ? $node->user->username : $this->getRequest()->getSession()
        ->read('Auth.User.username');
        echo $this->Html->beginBox(__d('atcmobile', 'Publishing'));
        echo $this->element('Atcmobapp/Core.admin/buttons', ['type' => h($type->title)]);
        echo $this->element('Atcmobapp/Core.admin/publishable');

        echo $this->Form->input('promote', [
        'label' => __d('atcmobile', 'Promoted to front page'),
        ]);
        echo $this->Html->endBox();

        echo $this->Html->beginBox(__d('atcmobile', '%s attributes', h($type->title)));
        echo $this->Form->autocomplete('user_id', [
            'label' => __d('atcmobile', 'Author'),
            'options' => $users,
            'default' => $loggedInUser['id'],
            'autocomplete' => [
                'default' => $username,
                'data-displayField' => 'username',
                'data-queryField' => 'name',
                'data-relatedElement' => '#user-id',
                'data-url' => Router::url([
                    'prefix' => 'api/v10',
                    'plugin' => 'Atcmobapp/Users',
                    'controller' => 'Users',
                    'action' => 'lookup',
                ]),
            ],
        ]);

        echo $this->Form->autocomplete('parent_id', [
            'label' => __d('atcmobile', 'Parent'),
            'options' => $parents,
            'default' => $node->parent_id,
            'autocomplete' => [
                'default' => $node->parent ? h($node->parent->title) : null,
                'data-displayField' => 'title',
                'data-queryField' => 'title',
                'data-relatedElement' => '#parent-id',
                'data-url' => $this->Url->build([
                    'prefix' => 'api/v10',
                    'plugin' => 'Atcmobapp/Nodes',
                    'controller' => 'Nodes',
                    'action' => 'lookup',
                    'type' => $node->type,
                ]),
            ],
        ]);

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
