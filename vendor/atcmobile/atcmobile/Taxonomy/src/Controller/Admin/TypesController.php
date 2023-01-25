<?php

namespace Atcmobapp\Taxonomy\Controller\Admin;

use Cake\Event\Event;

/**
 * Types Controller
 *
 * @category Controller
 * @package  Atcmobapp
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 *
 * @property \Atcmobapp\Taxonomy\Model\Table\TypesTable Types
 */
class TypesController extends AppController
{
    public $modelClass = 'Atcmobapp/Taxonomy.Types';

    public function initialize()
    {
        parent::initialize();

        $this->Crud->setConfig('actions.index', [
            'displayFields' => $this->Types->displayFields(),
        ]);
    }

    public function implementedEvents()
    {
        return parent::implementedEvents() + [
            'Crud.beforePaginate' => 'beforePaginate',
            'Crud.beforeRedirect' => 'beforeCrudRedirect',
            'Crud.beforeFind' => 'beforeCrudFind',
        ];
    }

    public function beforePaginate(Event $event)
    {
        /** @var \Cake\ORM\Query $query */
        $query = $event->getSubject()->query;

        $query->where([
            'plugin IS' => null
        ]);
    }

    public function beforeCrudFind(Event $event)
    {
        /** @var \Cake\ORM\Query $query */
        $query = $event->getSubject()->query;
        $query->contain([
            'Vocabularies',
        ]);
    }

    public function beforeCrudRedirect(Event $event)
    {
        if ($this->redirectToSelf($event)) {
            return;
        }
    }
}
