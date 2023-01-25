<?php

namespace Atcmobapp\Menus\Controller\Admin;

use Cake\Event\Event;

/**
 * Menus Controller
 *
 * @category Controller
 * @package  Atcmobapp.Menus.Controller
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class MenusController extends AppController
{

    public function implementedEvents()
    {
        return parent::implementedEvents() + [
            'Crud.beforeRedirect' => 'beforeCrudRedirect',
        ];
    }

    public function initialize()
    {
        parent::initialize();
        if ($this->getRequest()->getParam('action') === 'toggle') {
            $this->Atcmobapp->protectToggleAction();
        }
    }

    /**
     * @param \Cake\Event\Event $event
     * @return void
     */
    public function beforeCrudRedirect(Event $event)
    {
        if ($this->redirectToSelf($event)) {
            return;
        }
    }
}
