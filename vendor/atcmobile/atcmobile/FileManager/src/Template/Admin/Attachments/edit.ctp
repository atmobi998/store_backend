<?php

$this->loadHelper('Atcmobapp/FileManager.Filemanager');

$this->extend('Atcmobapp/Core./Common/admin_edit');

$this->Atcmobapp->adminScript(['Atcmobapp/FileManager.admin', 'Atcmobapp/FileManager.assets']);

$this->Breadcrumbs
    ->add(__d('atcmobile', 'Attachments'), ['plugin' => 'Atcmobapp/FileManager', 'controller' => 'Attachments', 'action' => 'index'])
    ->add(h($attachment->title), $this->getRequest()->getUri()->getPath());

if ($this->layout === 'admin_popup') :
    $this->append('title', ' ');
endif;

$formUrl = ['controller' => 'Attachments', 'action' => 'edit'];
if ($this->getRequest()->getQuery()) {
    $formUrl = array_merge($formUrl, $this->getRequest()->getQuery());
}

$this->append('form-start', $this->Form->create($attachment, [
    'url' => $formUrl,
]));

$this->append('tab-heading');
    echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Attachment'), '#attachment-main');
    echo $this->Atcmobapp->adminTabs();
$this->end();

$this->append('tab-content');
    echo $this->Html->tabStart('attachment-main');
        echo $this->Form->input('id');

        echo $this->Form->input('title', [
            'label' => __d('atcmobile', 'Title'),
        ]);
        echo $this->Form->input('excerpt', [
            'label' => __d('atcmobile', 'Excerpt'),
        ]);

        echo $this->Form->input('file_url', [
            'label' => __d('atcmobile', 'File URL'),
            'value' => $this->Url->build($attachment->asset->path, true),
            'readonly' => 'readonly']);

        echo $this->Form->input('file_type', [
            'label' => __d('atcmobile', 'Mime Type'),
            'value' => $attachment->asset->mime_type,
            'readonly' => 'readonly']);
        echo $this->Html->tabEnd();

        echo $this->Atcmobapp->adminTabs();
        $this->end();

        $this->append('panels');
        $redirect = $this->getRequest()->getQuery('redirect') ?: ['action' => 'index'];
        if ($this->getRequest()->getSession()->check('Wysiwyg.redirect')) {
            $redirect = $this->getRequest()->getSession()->read('Wysiwyg.redirect');
        }
        if ($this->getRequest()->getQuery('model')) {
            $redirect = array_merge(
                ['action' => 'browse'],
                ['?' => $this->getRequest()->getQuery()]
            );
        }
        echo $this->Html->beginBox(__d('atcmobile', 'Publishing')) .
        $this->Form->button($this->Html->icon('save') . __d('atcmobile', 'Save'), [
            'icon' => 'save',
            'class' => 'btn-outline-success',
        ]) . ' ' .
        $this->Html->link(
            $this->Html->icon('times') . __d('atcmobile', 'Cancel'),
            $redirect,
            [
                'class' => 'cancel btn btn-outline-danger',
                'escapeTitle' => false,
            ]
        );
        echo $this->Html->endBox();

        $fileType = explode('/', $attachment->asset->mime_type);
        $fileType = $fileType['0'];
        $path = $attachment->asset->path;
        if ($fileType == 'image') :
            $imgUrl = $this->AssetsImage->resize(
                $path,
                200,
                300,
                ['adapter' => $attachment->asset->adapter]
            );
        else :
            $imgUrl = $this->Html->image('Atcmobapp/Core./img/icons/' . $this->FileManager->mimeTypeToImage($attachment->mime_type)) . ' ' . $attachment->mime_type;
        endif;

        if (preg_match('/^image/', $attachment->asset->mime_type)) :
            echo $this->Html->beginBox(__d('atcmobile', 'Preview')) .
            $this->Html->link($imgUrl, $attachment->asset->path, [
                'data-toggle' => 'lightbox',
                'escapeTitle' => false,
            ]);
            echo $this->Html->endBox();
        endif;

        if (preg_match('/^video/', $attachment->asset->mime_type)) :
            echo $this->Html->beginBox(__d('atcmobile', 'Preview')) .
            $this->Html->media($attachment->asset->path, [
                'width' => 200,
                'controls' => true,
            ]);
            echo $this->Html->endBox();
        endif;

        $this->end();

        $this->append('form-end', $this->Form->end());
