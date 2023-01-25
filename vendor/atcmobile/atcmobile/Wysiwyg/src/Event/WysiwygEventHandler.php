<?php

namespace Atcmobapp\Wysiwyg\Event;

use Cake\Event\EventListenerInterface;
use Atcmobapp\Core\Atcmobapp;

/**
 * Wysiwyg Event Handler
 *
 * @category Event
 * @package  Atcmobapp.Ckeditor
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class WysiwygEventHandler implements EventListenerInterface
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

    public function onBootstrapComplete($event)
    {
        Atcmobapp::hookHelper('*', 'Atcmobapp/Wysiwyg.Wysiwyg');
    }
}
