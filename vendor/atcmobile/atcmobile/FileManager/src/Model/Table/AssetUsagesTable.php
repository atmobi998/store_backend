<?php

namespace Atcmobapp\FileManager\Model\Table;

use ArrayObject;
use Cake\Cache\Cache;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Atcmobapp\Core\Model\Table\AtcmobappTable;

/**
 * AssetUsages Table
 *
 */
class AssetUsagesTable extends AtcmobappTable
{

    /**
     * @param array $config
     * @return void
     */
    public function initialize(array $config)
    {
        $this->setTable('asset_usages');

        $this->belongsTo('Assets', [
            'className' => 'Atcmobapp/FileManager.Assets',
            'foreignKey' => 'asset_id',
        ]);

        $this->addBehavior('Atcmobapp/Core.Trackable');
    }

    /**
     * @param Event $event
     * @param EntityInterface $entity
     * @param ArrayObject $options
     *
     * @return bool
     */
    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        if (!empty($entity->featured_image)) {
            $entity->type = 'FeaturedImage';
            $entity->unsetProperty('featured_image');
        }

        return true;
    }

    /**
     * After Save Handler
     */
    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        Cache::clearGroup('nodes');
    }

}
