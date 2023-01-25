<?php

namespace Atcmobapp\Users\Controller\Admin;

use Cake\Event\Event;

/**
 * Roles Controller
 *
 * @category Controller
 * @package  Atcmobapp.Users.Controller
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class RolesController extends AppController
{
    public $modelClass = 'Atcmobapp/Users.Roles';

    public function initialize()
    {
        parent::initialize();

        $this->Crud->setConfig('actions.index', [
            'displayFields' => $this->Roles->displayFields()
        ]);
    }

    public function implementedEvents()
    {
        return parent::implementedEvents() + [
            'Crud.beforeRedirect' => 'beforeCrudRedirect',
        ];
    }

    public function beforeCrudRedirect(Event $event)
    {
        if ($this->redirectToSelf($event)) {
            return;
        }
    }

    public function index()
    {
        $this->Crud->on('beforePaginate', function (Event $event) {
            $event->getSubject()->query
                ->find('roleHierarchy')
                ->order(['ParentAro.lft' => 'DESC']);
        });

        return $this->Crud->execute();
    }
}
