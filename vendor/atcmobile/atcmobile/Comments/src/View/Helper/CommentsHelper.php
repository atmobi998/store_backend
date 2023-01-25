<?php

namespace Atcmobapp\Comments\View\Helper;

use Cake\View\Helper;
use Atcmobapp\Core\Atcmobapp;

/**
 * Comments Helper
 *
 * @category Comments.View/Helper
 * @package  Atcmobapp.Comments.View.Helper
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class CommentsHelper extends Helper
{

    /**
     * beforeRender
     */
    public function beforeRender($viewFile)
    {
        $request = $this->getView()->getRequest();
        if ($request->getParam('prefix') === 'admin' && !$request->is('ajax')) {
            $this->_adminTabs();
        }
    }

    /**
     * Hook admin tabs when type allows commenting
     */
    protected function _adminTabs()
    {
        $request = $this->getView()->getRequest();
        $controller = $request->getParam('controller');
        if ($controller === 'Types' || empty($this->_View->viewVars['type']->comment_status)) {
            return;
        }
        $title = __d('atcmobile', 'Comments');
        $element = 'Atcmobapp/Comments.comments_tab';
        Atcmobapp::hookAdminTab('Admin/' . $controller . '/add', $title, $element);
        Atcmobapp::hookAdminTab('Admin/' . $controller . '/edit', $title, $element);
    }
}
