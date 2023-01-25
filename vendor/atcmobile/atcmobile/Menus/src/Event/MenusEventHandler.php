<?php

namespace Atcmobapp\Menus\Event;

use Cake\Cache\Cache;
use Cake\Event\Event;
use Cake\Event\EventListenerInterface;

/**
 * MenusEventHandler
 *
 * @package  Atcmobapp.Menus.Event
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class MenusEventHandler implements EventListenerInterface
{

    /**
     * implementedEvents
     */
    public function implementedEvents()
    {
        return [
            'Controller.Links.afterPublish' => [
                'callable' => 'onAfterBulkProcess',
            ],
            'Controller.Links.afterUnpublish' => [
                'callable' => 'onAfterBulkProcess',
            ],
            'Controller.Links.afterDelete' => [
                'callable' => 'onAfterBulkProcess',
            ],
        ];
    }

    /**
     * Clear Links related cache after bulk operation
     *
     * @param Event $event
     * @return void
     */
    public function onAfterBulkProcess(Event $event)
    {
        Cache::clearGroup('menus', 'atcmobile_menus');
    }
}
