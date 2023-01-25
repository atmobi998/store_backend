<?php
$this->assign('title', __d('atcmobile', 'Step 2: Build database'));
?>

<p>
    <?php
    echo __d('atcmobile', 'Create tables and load initial data');
    ?>
</p>

<?php $this->start('buttons');

    echo $this->Html->link(__d('atcmobile', 'Build database'), [
        'plugin' => 'Atcmobapp/Install',
        'controller' => 'Install',
        'action' => 'data',
        '?' => ['run' => 1],
    ], [
        'tooltip' => [
            'data-title' => __d('atcmobile', 'Click here to build your database'),
            'data-placement' => 'left',
        ],
        'button' => 'success',
    ]);

    $this->end();
