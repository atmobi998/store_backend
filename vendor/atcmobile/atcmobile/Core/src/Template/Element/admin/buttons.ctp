<?php
/**
 * @var \Atcmobapp\Core\View\AtcmobappView $this
 */

$iconSet = $this->Theme->settings('iconDefaults.iconSet');
$cancelUrl = isset($cancelUrl) ? $cancelUrl : ['action' => 'index'];
$saveText = isset($saveText) ? $saveText : __d('atcmobile', 'Save');
$applyText = isset($applyText) ? $applyText : __d('atcmobile', 'Apply');
$cancelText = isset($cancelText) ? $cancelText : __d('atcmobile', 'Cancel');

$saveLabel = $this->Html->icon('save') . $saveText;
$applyLabel = $this->Html->icon('bolt') . $applyText;
$cancelLabel = $this->Html->icon('times') . $cancelText;

?>
<div class="clearfix">
    <div class="card-buttons d-flex justify-content-center">
    <?php
        echo $this->Form->button($saveLabel, ['class' => 'btn-outline-success']);
    if ($applyText) :
        echo $this->Form->button($applyLabel, ['class' => 'btn-outline-primary',
            'name' => '_apply',
        ]);
    endif;
        echo $this->Html->link($cancelLabel, $cancelUrl, [
            'escapeTitle' => false,
            'class' => 'cancel btn btn-outline-danger'
        ]);
        ?>
    </div>
</div>
