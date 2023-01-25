<?php

namespace Atcmobapp\Settings\Controller\Admin;

use Cake\Event\Event;

/**
 * Languages Controller
 *
 * @category Settings.Controller
 * @package  Atcmobapp.Settings
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class LanguagesController extends AppController
{
    public function initialize()
    {
        parent::initialize();

        $this->Crud->setConfig('actions.moveUp', [
            'className' => 'Atcmobapp/Core.Admin/MoveUp'
        ]);
        $this->Crud->setConfig('actions.moveDown', [
            'className' => 'Atcmobapp/Core.Admin/MoveDown'
        ]);
        $this->Crud->setConfig('actions.index', [
            'searchFields' => [
                'title',
                'alias',
                'locale',
            ],
        ]);

        $this->_setupPrg();
    }

    /**
     * Admin select
     *
     * @param int $id
     * @param string $modelAlias
     * @return void
     * @access public
     */
    public function select()
    {
        $id = $this->getRequest()->getQuery('id');
        $modelAlias = $this->getRequest()->getQuery('model');
        if ($id == null ||
            $modelAlias == null) {
            return $this->redirect(['action' => 'index']);
        }

        $this->set('title_for_layout', __d('atcmobile', 'Select a language'));
        $languages = $this->Languages->find('all', [
            'conditions' => [
                'status' => 1,
            ],
            'order' => 'weight ASC',
        ]);
        $this->set(compact('id', 'modelAlias', 'languages'));
    }

    public function index()
    {
        $this->Crud->on('beforePaginate', function (Event $e) {
            if (empty($this->getRequest()->getQuery('sort'))) {
                $e->getSubject()->query
                    ->orderDesc('status');
            }
        });

        return $this->Crud->execute();
    }
}
