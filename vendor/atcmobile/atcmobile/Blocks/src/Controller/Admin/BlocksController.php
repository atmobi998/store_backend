<?php

namespace Atcmobapp\Blocks\Controller\Admin;

use Cake\Event\Event;

/**
 * Blocks Controller
 *
 * @category Blocks.Controller
 * @package  Atcmobapp.Blocks.Controller
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class BlocksController extends AppController
{
    public $paginate = [
        'order' => [
            'region_id' => 'asc',
            'weight' => 'asc',
        ]
    ];

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Atcmobapp/Users.Roles');

        $this->_loadAtcmobappComponents(['BulkProcess']);
        $this->_setupPrg();

        $this->Crud->setConfig('actions.index', [
            'searchFields' => ['region_id', 'title']
        ]);
        $this->Crud->setConfig('actions.moveUp', [
            'className' => 'Atcmobapp/Core.Admin/MoveUp'
        ]);
        $this->Crud->setConfig('actions.moveDown', [
            'className' => 'Atcmobapp/Core.Admin/MoveDown'
        ]);

        if ($this->getRequest()->getParam('action') == 'toggle') {
            $this->Atcmobapp->protectToggleAction();
        }
    }

    /**
     * Admin process
     *
     * @return void
     * @access public
     */
    public function process()
    {
        $Blocks = $this->Blocks;
        list($action, $ids) = $this->BulkProcess->getRequestVars($Blocks->alias());

        $options = [
            'messageMap' => [
                'delete' => __d('atcmobile', 'Blocks deleted successfully'),
                'publish' => __d('atcmobile', 'Blocks published successfully'),
                'unpublish' => __d('atcmobile', 'Blocks unpublished successfully'),
                'copy' => __d('atcmobile', 'Blocks copied successfully'),
            ],
        ];

        return $this->BulkProcess->process($Blocks, $action, $ids, $options);
    }

    public function beforePaginate(Event $event)
    {
        $query = $event->getSubject()->query;
        $query->contain([
            'Regions'
        ]);

        $this->set('regions', $this->Blocks->Regions->find('list'));
    }

    public function beforeCrudRender()
    {
        $this->set('roles', $this->Roles->find('list'));
    }

    public function implementedEvents()
    {
        return parent::implementedEvents() + [
            'Crud.beforePaginate' => 'beforePaginate',
            'Crud.beforeRender' => 'beforeCrudRender',
            'Crud.beforeRedirect' => 'beforeCrudRedirect',
        ];
    }

    public function beforeCrudRedirect(Event $event)
    {
        if ($this->redirectToSelf($event)) {
            return;
        }
    }

    public function toggle()
    {
        return $this->Crud->execute();
    }
}
