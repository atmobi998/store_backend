<?php

$this->extend('Atcmobapp/Core./Common/admin_index');

$this->assign('title', __d('atcmobile', 'Themes'));

$this->Breadcrumbs->add(
    __d('atcmobile', 'Extensions'),
    ['plugin' => 'Atcmobapp/Extensions', 'controller' => 'Plugins', 'action' => 'index']
)
    ->add(__d('atcmobile', 'Themes'), $this->getRequest()->getUri()->getPath());

$this->start('action-buttons');
echo $this->Atcmobapp->adminAction(__d('atcmobile', 'Upload'), ['action' => 'add']);
$this->end() ?>

<div class="extensions-themes card-columns" style="column-count: 2">
<?php
foreach ($themesData as $themeAlias => $theme) :
    echo $this->element('admin/theme-preview', ['theme' => $theme]);
endforeach;
?>
</div>
