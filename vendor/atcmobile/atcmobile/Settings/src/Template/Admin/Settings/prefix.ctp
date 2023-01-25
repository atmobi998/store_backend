<?php

use Cake\Utility\Inflector;

$this->extend('Atcmobapp/Core./Common/admin_edit');

$this->Breadcrumbs->add(
    __d('atcmobile', 'Settings'),
    ['plugin' => 'Atcmobapp/Settings', 'controller' => 'Settings', 'action' => 'index']
)
    ->add($prefix, $this->getRequest()->getRequestTarget());

$this->assign('form-start', $this->Form->create(null, [
    'class' => 'protected-form',
    'type' => 'file',
]));

$this->append('tab-heading');
echo $this->Atcmobapp->adminTab($prefix, '#settings-main');
$this->end();

$this->append('tab-content');
echo $this->Html->tabStart('settings-main');
foreach ($settings as $setting) :
    if (!empty($setting->params['tab'])) {
        continue;
    }
    $keyE = explode('.', $setting->key);
    $keyTitle = Inflector::humanize($keyE['1']);

    $label = ($setting->title != null) ? $setting->title : $keyTitle;

    echo $this->SettingsForm->input($setting, $label);
endforeach;

echo $this->Html->tabEnd();
$this->end();

$this->start('buttons');
    echo $this->Html->beginBox(__d('atcmobile', 'Publishing'));
    echo $this->element('Atcmobapp/Core.admin/buttons', ['applyText' => false]);
    echo $this->Html->endBox();
$this->end();
