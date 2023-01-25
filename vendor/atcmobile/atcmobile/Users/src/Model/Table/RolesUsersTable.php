<?php

namespace Atcmobapp\Users\Model\Table;

use Cake\Core\Exception\Exception;
use Atcmobapp\Core\Model\Table\AtcmobappTable;

/**
 * RolesUsers
 *
 * @category Model
 * @package  Atcmobapp.Users.Model
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class RolesUsersTable extends AtcmobappTable
{

    public function initialize(array $config)
    {
        $this->belongsTo('Users', [
            'className' => 'Atcmobapp/Users.Users',
        ]);
        $this->belongsTo('Roles', [
            'className' => 'Atcmobapp/Users.Roles',
        ]);

        $this->addBehavior('Atcmobapp/Core.Trackable');
    }

    /**
     * Get Ids of Role's Aro assigned to user
     *
     * @param $userId integer user id
     * @return array array of Role Aro Ids
     */
    public function getRolesAro($userId)
    {
        $rolesUsers = $this->find('all', [
            'fields' => 'role_id',
            'conditions' => [
                $this->aliasField('user_id') => $userId,
            ],
            'cache' => [
                'name' => 'user_roles_' . $userId,
                'config' => 'nodes_index',
            ],
        ]);
        $aroIds = [];
        foreach ($rolesUsers as $rolesUser) {
            try {
                $aro = $this->Roles->Aros->node([
                    'model' => 'Roles',
                    'foreign_key' => $rolesUser->role_id,
                ])->first();
                $aroIds[] = $aro->id;
            } catch (Exception $e) {
                continue;
            }
        }

        return $aroIds;
    }
}
