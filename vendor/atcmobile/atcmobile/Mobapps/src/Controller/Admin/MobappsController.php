<?php

namespace Atcmobapp\Mobapps\Controller\Admin;

use Cake\Event\Event;
use Cake\Utility\Hash;
use Atcmobapp\Core\Controller\Component\AtcmobappComponent;
use Atcmobapp\Taxonomy\Controller\Component\TaxonomiesComponent;
use Atcmobapp\Taxonomy\Model\Entity\Type;

/**
 * Streets Controller
 *
 * @property StreetsTable Streets
 * @property AtcmobappComponent Atcmobapp
 * @property TaxonomiesComponent Taxonomies
 * @category Streets.Controller
 * @package  Atcmobapp.Streets
 * @version  1.0
 * @author   SP.NET Team <admin@streetplan.net>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://streetplan.net
 */
class MobappsController extends AppController
{
    /**
     * @return void
     * @throws \Crud\Error\Exception\MissingActionException
     * @throws \Crud\Error\Exception\ActionNotConfiguredException
     */
    public function initialize()
    {
        parent::initialize();

    }

    public function index()
    {

    }

    public function view($id=null)
    {

    }

    public function edit($id=null)
    {

    }

    public function add()
    {

    }

    public function create()
    {

    }

    public function updatePaths()
    {

    }

    public function process()
    {

    }

    public function beforePaginate(Event $event)
    {

    }

    public function beforeLookup(Event $event)
    {

    }

    public function beforeCrudRender(Event $event)
    {

    }

    public function beforeCrudFind(Event $event)
    {

    }

    public function beforeCrudSave(Event $event)
    {

    }

    public function beforeCrudRedirect(Event $event)
    {

    }

    public function afterCrudSave(Event $event)
    {

    }

    /**
     * @return array
     */
    public function implementedEvents()
    {
        return parent::implementedEvents() + [
            'Crud.beforeFind' => 'beforeCrudFind',
            'Crud.beforePaginate' => 'beforePaginate',
            'Crud.beforeLookup' => 'beforeLookup',
            'Crud.beforeRender' => 'beforeCrudRender',
            'Crud.beforeSave' => 'beforeCrudSave',
            'Crud.beforeRedirect' => 'beforeCrudRedirect',
            'Crud.afterSave' => 'afterCrudSave',
        ];
    }

    protected function _setCommonVariables(Type $type)
    {

    }

    public function toggle()
    {
        return $this->Crud->execute();
    }

    public function move($id, $direction = 'up', $step = '1')
    {

    }

    public function hierarchy()
    {

    }
}
