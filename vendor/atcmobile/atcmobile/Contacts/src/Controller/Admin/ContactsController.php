<?php

namespace Atcmobapp\Contacts\Controller\Admin;

use Cake\Event\Event;

/**
 * Contacts Controller
 *
 * @category Controller
 * @package  Atcmobapp.Contacts.Controller
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class ContactsController extends AppController
{
    public $modelClass = 'Atcmobapp/Contacts.Contacts';

    public function initialize()
    {
        parent::initialize();

        $this->Crud->setConfig('actions.index', [
            'displayFields' => $this->Contacts->displayFields()
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
}
