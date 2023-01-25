<?php

namespace Atcmobapp\Wysiwyg\View\Helper;

use Cake\Core\Configure;
use Cake\View\Helper;
use Atcmobapp\Core\Router;

/**
 * Wysiwyg Helper
 *
 * @category Wysiwyg.Helper
 * @package  Atcmobapp.Wysiwyg.View.Helper
 * @version  1.5
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class WysiwygHelper extends Helper
{

    /**
     * Other helpers used by this helper
     *
     * @var array
     * @access public
     */
    public $helpers = [
        'Atcmobapp',
        'Url'
    ];

    /**
     * beforeRender
     *
     * @param string $viewFile
     * @return void
     */
    public function beforeRender($viewFile)
    {
        $actions = array_keys(Configure::read('Wysiwyg.actions'));
        $currentAction = Router::getActionPath($this->getView()->getRequest(), true);
        $included = in_array($currentAction, $actions);
        if ($included) {
            $this->Atcmobapp->adminScript('Atcmobapp/Wysiwyg.wysiwyg.js');
        }
    }
}
