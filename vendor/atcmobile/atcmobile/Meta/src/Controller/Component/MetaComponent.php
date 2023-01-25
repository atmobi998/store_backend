<?php

namespace Atcmobapp\Meta\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Atcmobapp\Core\Atcmobapp;

/**
 * Meta Component
 *
 * @package Atcmobapp.Meta.Controller.Component
 */
class MetaComponent extends Component
{
    /**
     * startup
     */
    public function startup()
    {
        $controller = $this->_registry->getController();
        if ($controller->request->getParam('prefix') === 'admin') {
            $this->_adminTabs();

            if (empty($controller->request->getData('meta'))) {
                return;
            }
            $unlockedFields = [];
            foreach ($controller->request->getData('meta') as $uuid => $fields) {
                foreach ($fields as $field => $vals) {
                    $unlockedFields[] = 'meta.' . $uuid . '.' . $field;
                }
            }
            $controller->Security->setConfig('unlockedFields', $unlockedFields);
        } else {
            $this->loadMeta();
        }
    }

    protected function loadMeta()
    {
        $Meta = TableRegistry::get('Atcmobapp/Meta.Meta');
        $defaultMeta = $Meta->find()
            ->select(['key', 'value'])
            ->where([
                'foreign_key IS' => null,
            ]);
        $data = [];
        foreach ($defaultMeta as $meta) {
            $data[$meta->key] = $meta->value;
        }
        Configure::write('Meta.data', $data);
    }

    /**
     * Hook admin tabs for controllers whom its primary model has MetaBehavior attached.
     */
    protected function _adminTabs()
    {
        $controller = $this->_registry->getController();
        $table = TableRegistry::get($controller->modelClass);
        if ($table &&
            !$table->behaviors()
                ->has('Meta')
        ) {
            return;
        }
        $title = __d('atcmobile', 'Custom Fields');
        $element = 'Atcmobapp/Meta.admin/custom_fields_box';
        $controllerName = $this->request->getParam('controller');
        Atcmobapp::hookAdminBox("Admin/$controllerName/add", $title, $element);
        Atcmobapp::hookAdminBox("Admin/$controllerName/edit", $title, $element);
    }
}
