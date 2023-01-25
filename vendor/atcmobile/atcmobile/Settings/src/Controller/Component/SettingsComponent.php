<?php

namespace Atcmobapp\Settings\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\Event;

/**
 * Settings Component
 *
 * @category Component
 * @package  Atcmobapp.Settings.Controller.Component
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class SettingsComponent extends Component
{

    /**
     * @var Controller
     */
    protected $_controller;

    /**
     * startup
     */
    public function startup(Event $event)
    {
        $this->_controller = $event->getSubject();
        $this->_controller->loadModel('Atcmobapp/Settings.Settings');
    }
}
