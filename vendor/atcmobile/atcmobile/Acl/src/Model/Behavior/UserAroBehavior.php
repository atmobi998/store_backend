<?php

namespace Atcmobapp\Acl\Model\Behavior;

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;

/**
 * UserAro Behavior
 *
 * @category Behavior
 * @package  Atcmobapp.Acl.Model.Behavior
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class UserAroBehavior extends Behavior
{

    /**
     * Setup
     */
    public function initialize(array $config)
    {
        $this->_setupMultirole($this->_table);
    }

    /**
     * Enable Multiple Role, dynamically bind User Habtm Role
     */
    protected function _setupMultirole(Table $model)
    {
        if (!Configure::read('Access Control.multiRole')) {
            return;
        }
        $model->belongsToMany('Roles', [
            'className' => 'Atcmobapp/Users.Roles',
            'saveStrategy' => 'replace',
        ]);
    }

    /**
     * afterSave
     *
     * @param Model $event
     * @param bool $entity
     * @return void
     */
    public function afterSave(Event $event, Entity $entity)
    {
        // update ACO alias
        if (!empty($entity->username)) {
            $model = $event->getSubject();
            $arosTable = TableRegistry::get('Aros');

            $ref = ['model' => $model->getAlias(), 'foreign_key' => $entity->id];
            $node = $model->node($ref);
            $aro = $node->firstOrFail();

            $aro->alias = $entity->username;

            $arosTable->save($aro);
        }
        Cache::clearGroup('acl', 'permissions');
    }

    /**
     * afterDelete
     */
    public function afterDelete(Event $event)
    {
        Cache::clearGroup('acl', 'permissions');
    }
}
