<?php

namespace Atcmobapp\Contacts\Controller\Admin;

use Cake\Event\Event;

/**
 * Messages Controller
 *
 * @category Contacts.Controller
 * @package  Atcmobapp.Contacts.Controller
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class MessagesController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->_setupPrg();

        $this->_loadAtcmobappComponents(['BulkProcess']);

        $this->Crud->setConfig('actions.index', [
            'searchFields' => [
                'search', 'created' => ['type' => 'date'],
            ],
        ]);
    }

    /**
     * Admin process
     *
     * @return \Cake\Http\Response|void
     * @access public
     */
    public function process()
    {
        $Messages = $this->Messages;
        list($action, $ids) = $this->BulkProcess->getRequestVars($Messages->alias());

        $messageMap = [
            'delete' => __d('atcmobile', 'Messages deleted'),
            'read' => __d('atcmobile', 'Messages marked as read'),
            'unread' => __d('atcmobile', 'Messages marked as unread'),
        ];

        return $this->BulkProcess->process($Messages, $action, $ids, [
            'messageMap' => $messageMap,
        ]);
    }

    public function beforePaginate(Event $event)
    {
        $query = $event->getSubject()->query;

        $query->contain([
            'Contacts'
        ]);
    }

    public function beforeCrudRedirect(Event $event)
    {
        if ($this->redirectToSelf($event)) {
            return;
        }
    }

    public function implementedEvents()
    {
        return parent::implementedEvents() + [
            'Crud.beforePaginate' => 'beforePaginate',
            'Crud.beforeRedirect' => 'beforeCrudRedirect',
        ];
    }

    public function index()
    {
        $this->Crud->on('beforePaginate', function (Event $event) {
            $query = $event->getSubject()->query;
            if (empty($this->getRequest()->getQuery('sort'))) {
                $query->order([
                    $this->Messages->aliasField('created') => 'desc',
                ]);
            }
        });

        return $this->Crud->execute();
    }
}
