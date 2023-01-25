<table class="table permission-table">
    <?php
    $roleTitles = array_values($roles->toArray());
    $roleIds = array_keys($roles->toArray());

    $tableHeaders = [
        __d('atcmobile', 'Id'),
        __d('atcmobile', 'Alias'),
    ];
    $tableHeaders = array_merge($tableHeaders, $roleTitles);
    $tableHeaders = $this->Html->tableHeaders($tableHeaders);
    ?>

    <thead>
        <?= $tableHeaders ?>
    </thead>

    <?php
    $icon = '<i class="float-right"></i>';
    $currentController = '';
    foreach ($acos as $index => $aco) {
        $id = $aco->id;
        $alias = $aco->alias;
        $class = '';
        if (substr($alias, 0, 1) == '_') {
            $level = 1;
            $class .= 'level-' . $level;
            $oddOptions = ['class' => 'hidden controller-' . $currentController];
            $evenOptions = ['class' => 'hidden controller-' . $currentController];
            $alias = substr_replace($alias, '', 0, 1);
        } else {
            $level = 0;
            $class .= ' controller';
            if ($aco->children > 0) {
                $class .= ' perm-expand';
            }
            $oddOptions = [];
            $evenOptions = [];
            $currentController = $alias;
        }

        $row = [
            $id,
            $this->Html->div(trim($class), $alias . $icon, [
                'data-id' => $id,
                'data-alias' => $alias,
                'data-level' => $level,
            ]),
        ];

        foreach ($roles as $roleId => $roleTitle) {
            $row[] = '';
        }

        echo $this->Html->tableCells($row, $oddOptions, $evenOptions);
    }
    ?>

    <thead>
        <?= $tableHeaders ?>
    </thead>

</table>
