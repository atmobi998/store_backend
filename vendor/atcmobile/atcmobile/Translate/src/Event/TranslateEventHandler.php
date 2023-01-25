<?php

namespace Atcmobapp\Translate\Event;

use Cake\Datasource\EntityInterface;
use Cake\Event\EventListenerInterface;
use Atcmobapp\Translate\Translations;

/**
 * TranslateEventHandler
 *
 * @package  Atcmobapp.Translate.Event
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class TranslateEventHandler implements EventListenerInterface
{

    public function implementedEvents()
    {
        return [
            'Atcmobapp.bootstrapComplete' => [
                'callable' => 'onAtcmobappBootstrapComplete',
            ],
            'View.beforeRender' => [
                'callable' => 'onBeforeRender',
            ],
        ];
    }

    public function onAtcmobappBootstrapComplete($event)
    {
        Translations::translateModels();
    }

    public function onBeforeRender($event)
    {
        $View = $event->getSubject();
        if ($View->getRequest()->getParam('prefix') !== 'admin') {
            return;
        }
        if (empty($View->viewVars['viewVar'])) {
            return;
        }
        $viewVar = $View->viewVars['viewVar'];
        $entity = $View->viewVars[$viewVar];
        if (!$entity instanceof EntityInterface) {
            return;
        }
        if ($entity->isNew()) {
            return;
        }
        $title = __d('atcmobile', 'Translate');
        $View->append('action-buttons');
            echo $event->getSubject()->Atcmobapp->adminAction($title, [
                'plugin' => 'Atcmobapp/Translate',
                'controller' => 'Translate',
                'action' => 'index',
                'id' => $entity->get('id'),
                'model' => $entity->source(),
            ], [
                'icon' => 'translate',
            ]);
        $View->end();
    }
}
