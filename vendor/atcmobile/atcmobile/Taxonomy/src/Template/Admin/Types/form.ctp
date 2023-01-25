<?php

$this->extend('Atcmobapp/Core./Common/admin_edit');

$this->Breadcrumbs
    ->add(__d('atcmobile', 'Content'), ['plugin' => 'Atcmobapp/Nodes', 'controller' => 'Nodes', 'action' => 'index'])
    ->add(__d('atcmobile', 'Types'), ['plugin' => 'Atcmobapp/Taxonomy', 'controller' => 'Types', 'action' => 'index']);

if ($this->getRequest()->getParam('action') == 'edit') {
    $this->assign('title', __d('atcmobile', 'Edit Type'));

    $this->Breadcrumbs->add(h($type->title), $this->getRequest()->getRequestTarget());
}

if ($this->getRequest()->getParam('action') == 'add') {
    $this->Breadcrumbs->add(__d('atcmobile', 'Add'), $this->getRequest()->getRequestTarget());
}

$this->append('form-start', $this->Form->create($type));

$this->start('tab-heading');
    echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Type'), '#type-main');
    echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Taxonomy'), '#type-taxonomy');
    echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Comments'), '#type-comments');
    echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Params'), '#type-params');
$this->end();

$this->start('tab-content');

    echo $this->Html->tabStart('type-main');
        echo $this->Form->input('title', [
            'label' => __d('atcmobile', 'Title'),
            'data-slug' => '#alias',
        ]);
        echo $this->Form->input('alias', [
            'label' => __d('atcmobile', 'Alias'),
        ]);
        echo $this->Form->input('description', [
            'label' => __d('atcmobile', 'Description'),
        ]);
        echo $this->Html->tabEnd();
        echo $this->Html->tabStart('type-taxonomy');
        echo $this->Form->input('vocabularies._ids', [
            'class' => 'c-select',
            'multiple' => 'checkbox'
        ]);
        echo $this->Html->tabEnd();

        echo $this->Html->tabStart('type-comments');
        echo $this->Form->input('comment_status', [
            'type' => 'radio',
            'options' => [
                '0' => __d('atcmobile', 'Disabled'),
                '1' => __d('atcmobile', 'Read only'),
                '2' => __d('atcmobile', 'Read/Write'),
            ],
            'default' => 2,
            'label' => __d('atcmobile', 'Commenting'),
        ]);
        echo $this->Form->input('comment_approve', [
            'label' => 'Auto approve comments',
            'class' => false,
        ]);
        echo $this->Form->input('comment_spam_protection', [
            'label' => __d('atcmobile', 'Spam protection (requires Akismet API key)'),
            'class' => false,
        ]);
        echo $this->Form->input('comment_captcha', [
            'label' => __d('atcmobile', 'Use captcha? (requires Recaptcha API key)'),
            'class' => false,
        ]);
        echo $this->Html->link(__d('atcmobile', 'You can manage your API keys here.'), [
            'plugin' => 'Atcmobapp/Settings',
            'controller' => 'Settings',
            'action' => 'prefix',
            'Service',
        ]);
        echo $this->Html->tabEnd();

        echo $this->Html->tabStart('type-params');
        echo $this->Form->input('params', [
            'type' => 'stringlist',
            'label' => __d('atcmobile', 'Params'),
            'default' => 'routes=true',
        ]);
        echo $this->Html->tabEnd();

        $this->end();

        $this->start('panels');
        echo $this->Html->beginBox(__d('atcmobile', 'Publishing'));
        echo $this->element('Atcmobapp/Core.admin/buttons', ['type' => 'type']);
        echo $this->Form->input('format_show_author', [
        'label' => __d('atcmobile', 'Show author\'s name'),
        'class' => false,
        ]);
        echo $this->Form->input('format_show_date', [
        'label' => __d('atcmobile', 'Show date'),
        'class' => false,
        ]);
        echo $this->Form->input('format_use_wysiwyg', [
        'label' => __d('atcmobile', 'Use rich editor'),
        'class' => false,
        'default' => true
        ]);
        echo $this->Html->endBox();
        $this->end();
