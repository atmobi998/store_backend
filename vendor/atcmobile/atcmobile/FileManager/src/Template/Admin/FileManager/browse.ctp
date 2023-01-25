<?php

$this->extend('Atcmobapp/Core./Common/admin_index');
$tableHeaderClass = $this->Theme->getCssClass('tableHeaderClass');

$this->assign('title', __d('atcmobile', 'File Manager'));
$this->Breadcrumbs->add(__d('atcmobile', 'File Manager'), $this->getRequest()->getRequestTarget());

?>

<?php $this->start('action-buttons') ?>
<div class="btn-group">
    <?php
    echo $this->FileManager->adminAction(
        __d('atcmobile', 'Upload here'),
        ['controller' => 'FileManager', 'action' => 'upload'],
        $path
    );
    echo $this->FileManager->adminAction(
        __d('atcmobile', 'Create directory'),
        ['controller' => 'FileManager', 'action' => 'create_directory'],
        $path
    );
    echo $this->FileManager->adminAction(
        __d('atcmobile', 'Create file'),
        ['controller' => 'FileManager', 'action' => 'create_file'],
        $path
    );
    ?>
</div>
<?php $this->end() ?>

<?= $this->element('Atcmobapp/FileManager.admin/breadcrumbs') ?>

<div class="directory-content">
    <table class="table table-striped">
        <?php
        $tableHeaders = $this->Html->tableHeaders([
            '',
            __d('atcmobile', 'Directory content'),
            __d('atcmobile', 'Actions'),
        ]);
        ?>
        <thead class="<?= $tableHeaderClass ?>">
            <?= $tableHeaders ?>
        </thead>
        <?php
        // directories
        $rows = [];
        foreach ($content['0'] as $directory) :
            $actions = [];
            $fullpath = $path . $directory;
            $actions[] = $this->FileManager->linkDirectory(__d('atcmobile', 'Open'), $fullpath . DS);
            if ($this->FileManager->isDeletable($fullpath)) {
                $actions[] = $this->FileManager->link(__d('atcmobile', 'Delete'), [
                    'controller' => 'FileManager',
                    'action' => 'delete_directory',
                ], $fullpath);
            }
            $actions[] = $this->FileManager->link(__d('atcmobile', 'Rename'), [
                'controller' => 'FileManager',
                'action' => 'rename',
            ], $fullpath);
            $actions = $this->Html->div('item-actions', implode(' ', $actions));
            $rows[] = [
                $this->Html->image('/atcmobile/core/img/icons/folder.png'),
                $this->FileManager->linkDirectory($directory, $fullpath . DS),
                $actions,
            ];
        endforeach;
        echo $this->Html->tableCells($rows, ['class' => 'directory-listing'], ['class' => 'directory-listing']);

        // files
        $rows = [];
        foreach ($content['1'] as $file) :
            $actions = [];
            $fullpath = $path . $file;
            $icon = $this->FileManager->filename2icon($file);
            if ($icon == 'picture.png') :
                $image = '/' . str_replace(WWW_ROOT, '', $fullpath);
                $lightboxOptions = [
                    'data-toggle' => 'lightbox',
                    'escape' => false,
                ];
                $linkFile = $this->Html->link($file, $image, $lightboxOptions);
                $actions[] = $this->Html->link(__d('atcmobile', 'View'), $image, $lightboxOptions);
            else :
                $linkFile = $this->FileManager->linkFile($file, $fullpath);
                $actions[] = $this->FileManager->link(__d('atcmobile', 'Edit'), [
                        'plugin' => 'Atcmobapp/FileManager',
                        'controller' => 'FileManager',
                        'action' => 'edit_file',
                    ], $fullpath);
            endif;
            if ($this->FileManager->isDeletable($fullpath)) {
                $actions[] = $this->FileManager->link(__d('atcmobile', 'Delete'), [
                    'plugin' => 'Atcmobapp/FileManager',
                    'controller' => 'FileManager',
                    'action' => 'delete_file',
                ], $fullpath);
            }
            $actions[] = $this->FileManager->link(__d('atcmobile', 'Rename'), [
                'plugin' => 'Atcmobapp/FileManager',
                'controller' => 'FileManager',
                'action' => 'rename',
            ], $fullpath);
            $actions = $this->Html->div('item-actions', implode(' ', $actions));
            $rows[] = [
                $this->Html->image('/atcmobile/core/img/icons/' . $icon),
                $linkFile,
                $actions,
            ];
        endforeach;
        echo $this->Html->tableCells($rows, ['class' => 'file-listing'], ['class' => 'file-listing']);

        ?>
        <thead class="<?= $tableHeaderClass ?>">
            <?= $tableHeaders ?>
        </thead>
    </table>
</div>
