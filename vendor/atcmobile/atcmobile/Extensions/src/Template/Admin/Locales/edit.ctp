<?php

$this->extend('/Common/admin_edit');

$this->Breadcrumbs
    ->add(__d('atcmobile', 'Extensions'), array('plugin' => 'Atcmobapp/Extensions', 'controller' => 'Plugins', 'action' => 'index'))
    ->add(__d('atcmobile', 'Locales'), array('plugin' => 'Atcmobapp/Extensions', 'controller' => 'Locales', 'action' => 'index'))
    ->add($this->getRequest()->getParam('pass')[0], $this->getRequest()->getRequestTarget());

$this->append('form-start', $this->Form->create($locale, array(
    'url' => array(
        'plugin' => 'Atcmobapp/Extensions',
        'controller' => 'Locales',
        'action' => 'edit',
        $locale['locale'],
    ),
)));

$this->append('tab-heading');
    echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Content'), '#locale-content');
$this->end();

$this->append('tab-content');
    echo $this->Html->tabStart('locale-content') .
        $this->Form->input('content', array(
            'label' => __d('atcmobile', 'Content'),
            'data-placement' => 'top',
            'value' => $content,
            'type' => 'textarea',
        ));
    echo $this->Html->tabEnd();

$this->end();

$this->append('panels');
    echo $this->Html->beginBox(__d('atcmobile', 'Actions')) .
        $this->Form->button(__d('atcmobile', 'Save')) .
        $this->Html->link(__d('atcmobile', 'Cancel'),
            array('action' => 'index'),
            array('button' => 'danger')
        );
    echo $this->Html->endBox();

    echo $this->Atcmobapp->adminBoxes();
$this->end();
