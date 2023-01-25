<?php

namespace Atcmobapp\Extensions\Controller\Admin;

use Atcmobapp\Core\Controller\Admin\AppController as AtcmobappController;

/**
 * Extensions Admin Controller
 *
 * @category Controller
 * @package  Atcmobapp.Extensions.Controller
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class AppController extends AtcmobappController
{
    /**
     * beforeFilter
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        if (in_array($this->getRequest()->getParam('action'), ['admin_delete', 'admin_toggle', 'admin_activate'])) {
            $this->getRequest()->allowMethod('post');
        }
    }
}
