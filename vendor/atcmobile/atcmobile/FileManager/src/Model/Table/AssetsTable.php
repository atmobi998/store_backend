<?php

namespace Atcmobapp\FileManager\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Validation\Validator;
use Atcmobapp\Core\Atcmobapp;
use Atcmobapp\Core\Model\Table\AtcmobappTable;

class AssetsTable extends AtcmobappTable
{

    public $validate = [
        'file' => 'checkFileUpload'
    ];

    public function initialize(array $config)
    {
        $this->setTable('assets');

        $this->hasMany('AssetUsages', [
            'className' => 'Atcmobapp/FileManager.AssetUsages',
            'dependent' => true,
        ]);

        $this->belongsTo('Attachments', [
            'className' => 'Atcmobapp/FileManager.Attachments',
            'foreignKey' => 'foreign_key',
            'conditions' => [
                $this->aliasField('model') => 'Attachments',
            ],
        ]);

        $this->addBehavior('CounterCache', [
            'Attachments' => [
                'asset_count' => [
                    $this->aliasField('model') => 'Attachments',
                ],
            ],
        ]);
        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');
        $this->addBehavior('Atcmobapp/Core.Trackable');
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->requirePresence('adapter', 'create');

        return $validator;
    }

    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options = null)
    {
        $adapter = $entity->get('adapter');
        if (!$entity->filename) {
            $entity->filename = '';
        }
        if (!$entity->path) {
            $entity->path = '';
        }
        $Event = Atcmobapp::dispatchEvent('FileStorage.beforeSave', $this, [
            'record' => $entity,
            'adapter' => $adapter,
        ]);
        if ($Event->isStopped()) {
            return false;
        }

        return true;
    }

    public function beforeDelete(Event $event, EntityInterface $entity, ArrayObject $options = null)
    {
        $Event = Atcmobapp::dispatchEvent('FileStorage.beforeDelete', $this, [
            'record' => $entity,
        ]);
        if ($Event->isStopped()) {
            return false;
        }

        return true;
    }

    public function checkFileUpload($check)
    {
        switch ($check['file']['error']) {
            case UPLOAD_ERR_INI_SIZE:
                return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
            case UPLOAD_ERR_FORM_SIZE:
                return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
            case UPLOAD_ERR_PARTIAL:
                return 'The uploaded file was only partially uploaded.';
            case UPLOAD_ERR_NO_FILE:
                return 'No file was uploaded.';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Missing a temporary folder.';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Failed to write file to disk.';
            case UPLOAD_ERR_EXTENSION:
                return 'A PHP extension stopped the file upload.';
            case UPLOAD_ERR_OK:
                return true;
        }
    }
}
