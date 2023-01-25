<?php

use Atcmobapp\FileManager\Utility\StorageManager;

$this->extend('Atcmobapp/Core./Common/admin_edit');

$this->Html->css([
    'Atcmobapp/FileManager.jquery.fileupload',
    'Atcmobapp/FileManager.jquery.fileupload-ui',
], [
    'block' => true,
]);

$this->Atcmobapp->adminScript([
//  'Atcmobapp/FileManager.fileupload/vendor/jquery.ui.widget',
    'Atcmobapp/FileManager.fileupload/tmpl.min.js',
    'Atcmobapp/FileManager.fileupload/load-image.all.min',
    'Atcmobapp/FileManager.fileupload/canvas-to-blob.min',
    'Atcmobapp/FileManager.fileupload/jquery.iframe-transport',
    'Atcmobapp/FileManager.fileupload/jquery.fileupload',
    'Atcmobapp/FileManager.fileupload/jquery.fileupload-process',
    'Atcmobapp/FileManager.fileupload/jquery.fileupload-image',
    'Atcmobapp/FileManager.fileupload/jquery.fileupload-audio',
    'Atcmobapp/FileManager.fileupload/jquery.fileupload-video',
    'Atcmobapp/FileManager.fileupload/jquery.fileupload-validate',
    'Atcmobapp/FileManager.fileupload/jquery.fileupload-ui',
    'Atcmobapp/FileManager.admin',
    'Atcmobapp/FileManager.assets',
]);

$indexUrl = [
    'plugin' => 'Atcmobapp/FileManager',
    'controller' => 'Attachments',
    'action' => 'index'
];

if (!$this->getRequest()->getQuery('editor')) :
    $this->Breadcrumbs
        ->add(__d('atcmobile', 'Attachments'), $indexUrl)
        ->add(__d('atcmobile', 'Upload'), $this->getRequest()->getUri()->getPath());
endif;

if ($this->layout === 'admin_popup') :
    $this->append('title', ' ');
endif;

$formUrl = ['plugin' => 'Atcmobapp/FileManager', 'controller' => 'Attachments', 'action' => 'add'];
if ($this->getRequest()->getQuery('editor')) {
    $formUrl['editor'] = 1;
}
$this->append('form-start', $this->Form->create($attachment, [
    'url' => $formUrl,
    'type' => 'file',
    'id' => 'attachment-upload-form',
]));

$model = $this->getRequest()->getQuery('model') ?: null;
$foreignKey = $this->getRequest()->getQuery('foreign_key') ?: null;

$this->append('tab-heading');
    echo $this->Atcmobapp->adminTab(__d('atcmobile', 'Upload'), '#attachment-upload');
$this->end();

$this->append('tab-content');

    echo $this->Html->tabStart('attachment-upload');

if (isset($model) && isset($foreignKey)) :
    $assetUsage = 'asset.asset_usage.0.';
    echo $this->Form->input($assetUsage . 'model', [
        'type' => 'hidden',
        'value' => $model,
    ]);
    echo $this->Form->input($assetUsage . 'foreign_key', [
        'type' => 'hidden',
        'value' => $foreignKey,
    ]);
endif;

        echo $this->element('Atcmobapp/FileManager.admin/fileupload');

if (isset($model) && isset($foreignKey)) :
    echo $this->Form->input($assetUsage . 'featured_image', [
        'type' => 'checkbox',
        'label' => 'Featured Image',
    ]);
endif;

        echo $this->Form->input('asset.adapter', [
            'type' => 'select',
            'default' => 'LocalAttachment',
            'options' => StorageManager::configured(),
        ]);
        echo $this->Form->input('excerpt', [
            'label' => __d('atcmobile', 'Caption'),
        ]);
        echo $this->Form->input('title');
        echo $this->Form->input('status', [
            'type' => 'hidden', 'value' => true,
        ]);
        echo $this->Form->input('asset.model', [
            'type' => 'hidden',
            'value' => 'Attachments',
        ]);

        echo $this->Html->tabEnd();
        $this->end();

        $this->append('panels');
        $redirect = ['action' => 'index'];
        if ($this->getRequest()->getSession()->check('Wysiwyg.redirect')) {
            $redirect = $this->getRequest()->getSession()->read('Wysiwyg.redirect');
        }
        if ($this->getRequest()->getQuery('model')) {
            $redirect = array_merge(
                ['action' => 'browse'],
                ['?' => $this->getRequest()->getQuery()]
            );
            unset($redirect['?']['editor']);
        }
        echo $this->Html->beginBox(__d('atcmobile', 'Publishing')) .
        $this->Form->button(__d('atcmobile', 'Upload'), [
            'icon' => 'upload',
            'button' => 'primary',
            'class' => 'start btn-outline-success',
            'type' => 'submit',
            'id' => 'start_upload',
        ]) .
        $this->Form->end() . ' ' .
        $this->Html->link(__d('atcmobile', 'Cancel'), $redirect, [
            'class' => 'btn btn-outline-danger',
        ]);
        echo $this->Html->endBox();
        echo $this->Atcmobapp->adminBoxes();
        $this->end();

        $editorMode = isset($formUrl['editor']) ? $formUrl['editor'] : 0;
        $xhrUploadUrl = $this->Url->build($formUrl);
        $redirectUrl = $this->Url->build($indexUrl);
        $script = <<<EOF

    \$('[data-toggle=tab]:first').tab('show');
    var filesToUpload = [];
    var uploadContext = [];
    var uploadResults = [];
    var \$form = \$('#attachment-upload-form');
    \$form.fileupload({
        url: '$xhrUploadUrl',
        add: function(e, data) {
            var that = this;
            $.blueimp.fileupload.prototype.options.add.call(that, e, data)
            filesToUpload.push(data.files[0]);
            uploadContext.push(data.context);
        },
        fail: function(e, data) {
            var that = this;
            filesToUpload.pop(data.files[0])
            uploadContext.pop(data.context)
            $.blueimp.fileupload.prototype.options.fail.call(that, e, data)
        }
    });

    var \$startUpload = $('#start_upload');

    var uploadHandler = function(e) {
        var enableStartUpload = function() {
            \$startUpload
                .one('click', uploadHandler)
                .html('Upload')
                .removeAttr('disabled');
        }

        if (filesToUpload.length == 0) {
            alert('No files to upload');
            enableStartUpload();
            return false;
        }

        for (var i in filesToUpload) {
            var xhr = \$form.fileupload('send', {
                files: [filesToUpload[i]],
                context: uploadContext[i]
            })
                .then(function(result, textStatus, jqXHR) {
                    uploadResults.push(result);
                })
                .catch(function(jqXHR, textStatus, errorThrown) {
                    if (jqXHR.responseJSON) {
                        uploadResults.push(jqXHR.responseJSON);
                    } else {
                        uploadResults.push(errorThrown);
                    }
                });
        }

        \$startUpload.html('<i class="fa fa-spin fa-spinner"></i> Upload')
            .attr('disabled', true);

        var checkInterval = setInterval(function() {
            var uploadCount = filesToUpload.length;
            var uploadSuccess = false;
            var errorMessage = false;
            for (var i = 0; i < uploadCount; i++) {
                if (typeof uploadResults[i] !== 'undefined') {
                    var errorType = typeof uploadResults[i].error;
                    if (errorType !== 'undefined') {
                        if (errorType === 'string') {
                            uploadSuccess = false;
                            errorMessage = uploadResults[i].error;
                        } else {
                            uploadSuccess = uploadResults[i].error === false;
                        }
                    }
                    if (typeof uploadResults[i].message !== 'undefined') {
                        errorMessage = uploadResults[i].message;
                        uploadSuccess = false
                    }
                }
                if (!uploadSuccess) {
                    break;
                }
            }

            if (uploadSuccess) {
                clearInterval(checkInterval);
                if (uploadCount > 1) {
                    alert(uploadCount + ' files uploaded successfully');
                }
                if ($editorMode == 1) {
                    \$startUpload
                        .removeAttr('disabled')
                        .text('Close')
                        .one('click', function(e) {
                            window.close();
                            return false;
                        });
                } else {
                    window.location = '$redirectUrl';
                }
            }

            if (errorMessage) {
                clearInterval(checkInterval);
                alert(errorMessage)
                filesToUpload = [];
                uploadContext = [];
                uploadResults = [];
                enableStartUpload();
            }
        }, 1000);

        return false;
    };

    \$startUpload.one('click', uploadHandler);
    Attachments.init();
    Assets.init();
EOF;

        $this->Js->buffer($script);
