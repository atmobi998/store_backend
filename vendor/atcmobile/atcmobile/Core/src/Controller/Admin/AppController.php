<?php

namespace Atcmobapp\Core\Controller\Admin;

use Cake\Core\Configure;
use Cake\Event\Event;
use Atcmobapp\Core\Controller\AppController as AtcmobappAppController;
use Atcmobapp\Core\Atcmobapp;
use Crud\Controller\ControllerTrait;

/**
 * Atcmobapp App Controller
 *
 * @category Atcmobapp.Controller
 * @package  Atcmobapp.Atcmobapp.Controller
 * @version  1.5
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 *
 * @property \Crud\Controller\Component\CrudComponent $Crud
 */
class AppController extends AtcmobappAppController
{
    use ControllerTrait;

    /**
     * Load the theme component with the admin theme specified
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('Crud.Crud', [
            'actions' => [
                'index' => [
                    'className' => 'Atcmobapp/Core.Admin/Index'
                ],
                'lookup' => [
                    'className' => 'Crud.Lookup',
                    'findMethod' => 'all'
                ],
                'view' => [
                    'className' => 'Crud.View'
                ],
                'add' => [
                    'className' => 'Atcmobapp/Core.Admin/Add',
                    'messages' => [
                        'success' => [
                            'text' => __d('atcmobile', '{name} created successfully'),
                            'params' => [
                                'type' => 'success',
                                'class' => ''
                            ]
                        ],
                        'error' => [
                            'params' => [
                                'type' => 'error',
                                'class' => ''
                            ]
                        ]
                    ]
                ],
                'edit' => [
                    'className' => 'Atcmobapp/Core.Admin/Edit',
                    'messages' => [
                        'success' => [
                            'text' => __d('atcmobile', '{name} updated successfully'),
                            'params' => [
                                'type' => 'success',
                                'class' => ''
                            ]
                        ],
                        'error' => [
                            'params' => [
                                'type' => 'error',
                                'class' => ''
                            ]
                        ]
                    ]
                ],
                'toggle' => [
                    'className' => 'Atcmobapp/Core.Admin/Toggle'
                ],
                'delete' => [
                    'className' => 'Crud.Delete'
                ]
            ],
            'listeners' => [
                'Crud.Redirect',
                'Crud.Search',
                'Crud.RelatedModels',
                'Atcmobapp/Core.Flash',
            ]
        ]);

        $this->Theme->setConfig('theme', Configure::read('Site.admin_theme'));
    }

    /**
     * beforeFilter
     *
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        $this->viewBuilder()->setLayout('admin');

        parent::beforeFilter($event);

        Atcmobapp::dispatchEvent('Atcmobapp.beforeSetupAdminData', $this);
    }

    public function index()
    {
        return $this->Crud->execute();
    }

    public function view($id)
    {
        return $this->Crud->execute();
    }

    public function add()
    {
        return $this->Crud->execute();
    }

    public function edit($id)
    {
        return $this->Crud->execute();
    }

    public function delete($id)
    {
        return $this->Crud->execute();
    }

    protected function redirectToSelf(Event $event)
    {
        $subject = $event->getSubject();
        if ($subject->success) {
            $data = $this->getRequest()->getData();
            if (isset($data['_apply'])) {
                $entity = $subject->entity;

                return $this->redirect(['action' => 'edit', $entity->id]);
            }
        }
    }
}
