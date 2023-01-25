<table class="table table-striped">
    <?php
    $tableHeaders = $this->Html->tableHeaders([
        '',
        __d('atcmobile', 'Id'),
        __d('atcmobile', 'Title'),
        __d('atcmobile', 'Slug'),
    ]);
    ?>
    <thead>
        <?= $tableHeaders ?>
    </thead>
    <?php
    $rows = [];

    foreach ($terms as $term) :
        $titleCol = $term->title;
        if (isset($defaultType)) {
            $titleCol = $this->Html->link($term->title, [
                'plugin' => 'Atcmobapp/Nodes',
                'controller' => 'Nodes',
                'action' => 'term',
                'type' => $defaultType['alias'],
                'term' => $term->slug,
                'prefix' => false,
            ], [
                'class' => 'item-choose',
                'data-chooser-type' => 'Node',
                'data-chooser-id' => $term->id,
                'data-chooser-title' => $term->title,
                'rel' => sprintf(
    'plugin:%s/controller:%s/action:%s/type:%s/slug:%s',
    'Atcmobapp/Nodes',
            'Nodes',
            'term',
            $defaultType['alias'],
            $term->slug
            ),
            ]);
        }

        $rows[] = [
            '',
            $term->id,
            h($titleCol),
            $term->slug,
        ];
    endforeach;

    echo $this->Html->tableCells($rows);

    ?>
</table>
