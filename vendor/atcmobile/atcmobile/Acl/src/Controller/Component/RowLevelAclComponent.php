<?php

namespace Atcmobapp\Acl\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Atcmobapp\Core\Atcmobapp;
use Exception;

/**
 * When "Access Control.rowLevel" Setting is active, this component will perform
 * the necessary setup on controller's primary model and hook the element for
 * backend use.
 *
 * You can also use it to configure the action mappings used by AclCachedAuthorize
 * class, for example:
 *
 * ```
 *      class ItemsController extends AppController {
 *          public $components = [
 *              'RowLevelAcl' => [
 *                  'className' => 'Atcmobapp/Acl.RowLevelAcl',
 *                  'settings' => [
 *                      'actionMap' => [
 *                          'reserve' => 'update', // action map
 *                      ],
 *                  ],
 *              ]
 *         ];
 *      }
 * ```
 *
 * @category Component
 * @package  Atcmobapp.Acl.Controller.Component
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class RowLevelAclComponent extends Component
{

    /**
     * controller instance
     */
    protected $_controller;

    /**
     * initialize
     *
     * attaches Acl and RowLevelAcl behavior to the controller's primary model and
     * hook the appropriate admin tabs
     */
    public function initialize(array $settings)
    {
        $controller = $this->getController();
        $Model = $controller->{$controller->name};
        $Model->addBehavior('Acl', [
            'className' => 'Atcmobapp/Core.AtcmobappAcl', 'type' => 'controlled',
        ]);
        $Model->addBehavior('Atcmobapp/Acl.RowLevelAcl');

        $name = $controller->name;
        $element = 'Atcmobapp/Acl.admin/row_acl';
        if (!empty($this->settings['adminTabElement'])) {
            $element = $this->settings['adminTabElement'];
        }
        $adminTabActions = ['add', 'edit'];
        if (!empty($this->_config['adminTabActions'])) {
            $adminTabActions += $this->_config['adminTabActions'];
        }
        foreach ($adminTabActions as $action) {
            Atcmobapp::hookAdminTab("Admin/$name/$action", __d('atcmobile', 'Permissions'), $element);
        }
    }

    /**
     * startup
     */
    public function startup(Event $event)
    {
        $controller = $this->getController();
        if (!empty($controller->request->params['pass'][0])) {
            $id = $controller->request->params['pass'][0];
            $this->_rolePermissions($id);
        }
    }

    /**
     * Retrieve a list of roles with access status for a given node
     *
     * @param int $id Node id
     * @return void
     */
    protected function _rolePermissions($id)
    {
        $controller = $this->getController();
        $Permission = $controller->Acl->adapter()->Permission;
        $Role = TableRegistry::get('Atcmobapp/Users.Roles');
        $roles = $Role->find('list', [
            'cache' => ['name' => 'roles', 'config' => 'permissions'],
        ]);
        $modelClass = $controller->name;
        $aco = ['model' => $modelClass, 'foreign_key' => $id];
        foreach ($roles as $roleId => $role) {
            $aro = ['model' => 'Roles', 'foreign_key' => $roleId];
            try {
                $allowed = $Permission->check($aro, $aco);
            } catch (Exception $e) {
                $allowed = false;
            }
            $tmp[] = [
                'id' => $roleId, 'title' => $role, 'allowed' => $allowed
            ];
        }
        $sorted = collection($tmp)->sortBy('title', SORT_ASC, SORT_NATURAL);
        $rolePermissions = $sorted->toArray();
        $controller->set(compact('rolePermissions'));
    }
}
