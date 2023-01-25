<?php

namespace Atcmobapp\Blocks\Controller\Admin;

use Cake\Event\Event;

/**
 * Regions Controller
 *
 * @category Blocks.Controller
 * @package  Atcmobapp.Blocks.Controller
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class RegionsController extends AppController
{
    public $modelClass = 'Atcmobapp/Blocks.Regions';

    public function initialize()
    {
        parent::initialize();

        $this->_setupPrg();

        $this->Crud->setConfig('actions.index', [
            'displayFields' => $this->Regions->displayFields(),
            'searchFields' => ['title']
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
