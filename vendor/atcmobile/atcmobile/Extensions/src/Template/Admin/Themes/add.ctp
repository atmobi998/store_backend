<?php

$this->extend('/Common/admin_edit');

$this->Breadcrumbs->add(
    __d('atcmobile', 'Extensions'),
    ['plugin' => 'Atcmobapp/Extensions', 'controller' => 'Plugins', 'action' => 'index']
)
    ->add(
        __d('atcmobile', 'Themes'),
        ['plugin' => 'Atcmobapp/Extensions', 'controller' => 'Themes', 'action' => 'index']
    )
    ->add(__d('atcmobile', 'Upload'), $this->getRequest()->getRequestTarget());

$this->append('form-start', $this->Form->create(null, [
    'url' => [
        'plugin' => 'Atcmobapp/Extensions',
        'controller' => 'Themes',
        'action' => 'add',
    ],
    'type' => 'file',
]));

$this->append('tab-heading');
echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Upload'), '#themes-upload');
$this->end();

$this->append('tab-content');
echo $this->Html->tabStart('themes-upload') . $this->Form->input('Theme.file', [
        'type' => 'file',
        'class' => 'c-file',
        'required' => true,
    ]);
echo $this->Html->tabEnd();
$this->end();

$this->append('panels');
echo $this->Html->beginBox(__d('atcmobile', 'Publishing'));
?>
<div class="clearfix">
    <div class="card-buttons d-flex justify-content-center">
    <?php
        echo $this->Form->button(__d('atcmobile', 'Upload'), [
            'class' => 'btn-outline-primary',
        ]);
        echo $this->Html->link(__d('atcmobile', 'Cancel'), [
            'action' => 'index',
        ], [
            'button' => 'outline-danger',
        ]);
    ?>
    </div>
</div>
<?php
echo $this->Html->endBox();
$this->end();
