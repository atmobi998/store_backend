<?php

namespace Atcmobapp\Ckeditor\Event;

use Cake\Core\Configure;
use Cake\Event\EventListenerInterface;
use Atcmobapp\Core\Atcmobapp;

/**
 * Ckeditor Event Handler
 *
 * @category Event
 * @package  Atcmobapp.Ckeditor
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class CkeditorEventHandler implements EventListenerInterface
{

    /**
     * implementedEvents
     *
     * @return array
     */
    public function implementedEvents()
    {
        return [
            'Atcmobapp.bootstrapComplete' => [
                'callable' => 'onBootstrapComplete',
            ],
        ];
    }

    /**
     * Hook helper
     */
    public function onBootstrapComplete($event)
    {
        foreach ((array)Configure::read('Wysiwyg.actions') as $action => $settings) {
            if (is_numeric($action)) {
                $action = $settings;
            }
            $action = base64_decode($action);
            $action = explode('/', $action);
            array_pop($action);
            Atcmobapp::hookHelper(implode('/', $action), 'Atcmobapp/Ckeditor.Ckeditor');
        }
    }

}
