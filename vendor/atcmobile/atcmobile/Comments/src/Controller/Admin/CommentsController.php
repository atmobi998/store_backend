<?php

namespace Atcmobapp\Comments\Controller\Admin;

use Cake\Event\Event;

/**
 * Comments Controller
 *
 * @category Controller
 * @package  Atcmobapp.Comments.Controller
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class CommentsController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->_loadAtcmobappComponents(['Akismet', 'BulkProcess', 'Recaptcha']);
        $this->Crud->setConfig('actions.index', [
            'displayFields' => $this->Comments->displayFields()
        ]);
    }

    /**
     * Admin process
     *
     * @return void
     * @access public
     */
    public function process()
    {
        list($action, $ids) = $this->BulkProcess->getRequestVars($this->Comments->getAlias());

        $options = [
            'messageMap' => [
                'delete' => __d('atcmobile', 'Comments deleted'),
                'publish' => __d('atcmobile', 'Comments published'),
                'unpublish' => __d('atcmobile', 'Comments unpublished'),
            ]
        ];

        $this->BulkProcess->process($this->Comments, $action, $ids, $options);
    }

    public function beforePaginate(Event $event)
    {
        $query = $event->getSubject()->query;

        $query->find('relatedEntity');
    }

    public function implementedEvents()
    {
        return parent::implementedEvents() + [
            'Crud.beforePaginate' => 'beforePaginate',
            'Crud.beforeRedirect' => 'beforeCrudRedirect',
        ];
    }

    public function beforeCrudRedirect(Event $event)
    {
        if ($this->redirectToSelf($event)) {
            return;
        }
    }
}
