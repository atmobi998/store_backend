<?php

namespace Atcmobapp\Mobapps\Event;

use Cake\Cache\Cache;
use Cake\Core\Plugin;
use Cake\Event\EventListenerInterface;
use Cake\ORM\TableRegistry;
use Atcmobapp\Core\Atcmobapp;
use Atcmobapp\Core\Nav;

/**
 * Mobapps Event Handler
 *
 * @category Event
 * @package  Atcmobapp.Mobapps.Event
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://streetplan.net
 */
class MobappsEventHandler implements EventListenerInterface
{

    /**
     * implementedEvents
     */
    public function implementedEvents()
    {
        return [
            'Atcmobapp.bootstrapComplete' => [
                'callable' => 'onBootstrapComplete',
            ],
            'Atcmobapp.setupAdminData' => [
                'callable' => 'onSetupAdminData',
            ],
            'Controller.Links.setupLinkChooser' => [
                'callable' => 'onSetupLinkChooser',
            ],
            'Controller.Mobapps.afterPublish' => [
                'callable' => 'onAfterBulkProcess',
            ],
            'Controller.Mobapps.afterUnpublish' => [
                'callable' => 'onAfterBulkProcess',
            ],
            'Controller.Mobapps.afterPromote' => [
                'callable' => 'onAfterBulkProcess',
            ],
            'Controller.Mobapps.afterUnpromote' => [
                'callable' => 'onAfterBulkProcess',
            ],
            'Controller.Mobapps.afterDelete' => [
                'callable' => 'onAfterBulkProcess',
            ],
        ];
    }

    /**
     * Setup admin data
     */
    public function onSetupAdminData($event)
    {

    }

    /**
     * onBootstrapComplete
     */
    public function onBootstrapComplete($event)
    {
 
    }

    /**
     * Setup Link chooser values
     *
     * @return void
     */
    public function onSetupLinkChooser($event)
    {

    }

    /**
     * Clear Mobapps related cache after bulk operation
     *
     * @param CakeEvent $event
     * @return void
     */
    public function onAfterBulkProcess($event)
    {

    }
}
