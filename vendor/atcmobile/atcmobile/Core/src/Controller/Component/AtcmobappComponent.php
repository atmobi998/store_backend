<?php

namespace Atcmobapp\Core\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Controller;
use Cake\Core\App;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\Event;
use Cake\Network\Exception\MethodNotAllowedException;
use Cake\ORM\Table;
use Cake\ORM\TableRegistry;
use Atcmobapp\Core\Exception\Exception;
use Atcmobapp\Core\Nav;

/**
 * Atcmobapp Component
 *
 * @category Component
 * @package  Atcmobapp.Atcmobapp.Controller.Component
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class AtcmobappComponent extends Component
{

    /**
     * Blocks data: contains parsed value of bb-code like strings
     *
     * @var array
     * @access public
     */
    public $blocksData = [
        'menus' => [],
        'vocabularies' => [],
        'nodes' => [],
    ];

    /**
     * controller
     *
     * @var Controller
     */
    protected $_controller = null;

    /**
     * Method to lazy load classes
     *
     * @return mixed
     */
    public function __get($name)
    {
        switch ($name) {
            case '_AtcmobappPlugin':
            case '_AtcmobappTheme':
                if (!isset($this->{$name})) {
                    $class = 'Atcmobapp\\Extensions\\' . substr($name, 1);
                    $this->{$name} = new $class();
                    if (method_exists($this->{$name}, 'setController')) {
                        $this->{$name}->setController($this->_controller);
                    }
                }

                return $this->{$name};
            case 'roleId':
                return $this->roleId();
            default:
                return parent::__get($name);
        }
    }

    /**
     * Startup
     *
     * @param object $event instance of controller
     * @return void
     */
    public function startup(Event $event)
    {
        $this->_controller = $event->getSubject();

        if ($this->_controller->request->getParam('prefix') == 'admin') {
            if (!$this->_controller->request->getParam('requested')) {
                $this->_adminData();
            }
        }
    }

    /**
     * Set variables for admin layout
     *
     * @return void
     */
    protected function _adminData()
    {
        $_siteTitle = Configure::read('Site.title');
        $this->_controller->set(compact('_siteTitle'));
        $this->_adminMenus();
    }

    /**
     * Setup admin menu
     */
    protected function _adminMenus()
    {
        Nav::add('top-left', 'site', [
            'icon' => false,
            'title' => __d('atcmobile', 'Visit website'),
            'url' => '/',
            'weight' => 0,
            'htmlAttributes' => [
                'target' => '_blank',
            ],
        ]);

        $user = $this->getController()->request->getSession()->read('Auth.User');
        if (empty($user)) {
            return;
        }
        $gravatarUrl = '<img src="//www.gravatar.com/avatar/' . md5($user['email']) . '?s=23" class="rounded mx-auto"/> ';
        Nav::add('top-right', 'user', [
            'icon' => false,
            'title' => $user['username'],
            'before' => $gravatarUrl,
            'url' => '#',
            'children' => [
                'profile' => [
                    'title' => __d('atcmobile', 'Profile'),
                    'icon' => 'user',
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Atcmobapp/Users',
                        'controller' => 'Users',
                        'action' => 'view',
                        $user['id'],
                    ],
                ],
                'separator-1' => [
                    'separator' => true,
                ],
                'logout' => [
                    'icon' => 'power-off',
                    'title' => __d('atcmobile', 'Logout'),
                    'url' => [
                        'prefix' => 'admin',
                        'plugin' => 'Atcmobapp/Users',
                        'controller' => 'Users',
                        'action' => 'logout',
                    ],
                ],
            ],
        ]);
    }

    /**
     * Gets the Role Id of the current user
     *
     * @return int Role Id
     */
    public function roleId()
    {
        $roleId = $this->_controller->request->getSession()->read('Auth.User.role_id');
        if ($roleId) {
            return $roleId;
        }

        return TableRegistry::get('Atcmobapp/Users.Roles')->byAlias('public');
    }

    /**
     * ACL: add ACO
     *
     * Creates ACOs with permissions for roles.
     *
     * @param string $action possible values: ControllerName, ControllerName/method_name
     * @param array $allowRoles Role aliases
     * @return void
     */
    public function addAco($action, $allowRoles = [])
    {
        $this->_controller->AtcmobappAccess->addAco($action, $allowRoles);
    }

    /**
     * ACL: remove ACO
     *
     * Removes ACOs and their Permissions
     *
     * @param string $action possible values: ControllerName, ControllerName/method_name
     * @return void
     */
    public function removeAco($action)
    {
        $this->_controller->AtcmobappAccess->removeAco($action);
    }

    /**
     * Toggle field status
     *
     * @param $table Table instance
     * @param $id integer Model id
     * @param $status integer current status
     * @param $field string field name to toggle
     * @throws Exception
     */
    public function fieldToggle(Table $table, $id, $status, $field = 'status')
    {
        if (empty($id) || $status === null) {
            throw new Exception(__d('atcmobile', 'Invalid content'));
        }

        $status = (int)!$status;

        $entity = $table->get($id);
        $entity->{$field} = $status;
        $this->_controller->viewBuilder()->setLayout('ajax');
        if ($table->save($entity)) {
            $this->_controller->set(compact('id', 'status'));
            $this->_controller->render('Atcmobapp/Core./Common/admin_toggle');
        } else {
            throw new Exception(__d('atcmobile', 'Failed toggling field %s to %s', $field, $status));
        }
    }

    /**
     * Get a list of possible view paths for current request
     *
     * The default view paths are retrieved view App::path('View').  This method
     * injects the theme path and also considers whether a plugin is used.
     *
     * The paths that will be used for fallback is typically:
     *
     *   - APP/View/<Controller>
     *   - APP/Themed/<Theme>/<Controller>
     *   - APP/Themed/<Theme>/Plugin/<Plugin>/<Controller>
     *   - APP/Plugin/<Plugin/View/<Controller>
     *   - APP/Vendor/atcmobile/atcmobile/Atcmobapp/View
     *
     * @param Controller $controller
     * @return array A list of view paths
     */
    protected function _setupViewPaths(Controller $controller)
    {
        $defaultViewPaths = App::path('Template');
        $pos = array_search(APP . 'Template' . DS, $defaultViewPaths);
        if ($pos !== false) {
            $viewPaths = array_splice($defaultViewPaths, 0, $pos + 1);
        } else {
            $viewPaths = $defaultViewPaths;
        }
        if ($controller->viewBuilder()->getTheme()) {
            $themePaths = App::path('Template', $controller->viewBuilder()->getTheme());
            foreach ($themePaths as $themePath) {
                $viewPaths[] = $themePath;
                if ($controller->getPlugin()) {
                    $viewPaths[] = $themePath . 'Plugin' . DS . $controller->getPlugin() . DS;
                }
            }
        }
        if ($controller->getPlugin()) {
            $viewPaths = array_merge($viewPaths, App::path('Template', $controller->getPlugin()));
        }
        $viewPaths = array_merge($viewPaths, $defaultViewPaths);

        return $viewPaths;
    }

    /**
     * View Fallback
     *
     * Looks for view file through the available view paths.  If the view is found,
     * set Controller::$view variable.
     *
     * @param string|array $templates view path or array of view paths
     * @return void
     */
    public function viewFallback($templates)
    {
        $templates = (array)$templates;
        $controller = $this->_controller;
        $templatePaths = $this->_setupViewPaths($controller);
        foreach ($templates as $template) {
            foreach ($templatePaths as $templatePath) {
                $templatePath = $templatePath . $this->_viewPath() . DS . $template;
                if (file_exists($templatePath . '.ctp')) {
                    $controller->viewBuilder()->template($this->_viewPath() . DS . $template);

                    return;
                }
            }
        }
    }

    protected function _viewPath()
    {
        $viewPath = $this->_controller->getName();
        if (!empty($this->request->getParam('prefix'))) {
            $prefixes = array_map(
                'Cake\Utility\Inflector::camelize',
                explode('/', $this->_controller->request->params['prefix'])
            );
            $viewPath = implode(DS, $prefixes) . DS . $viewPath;
        }

        return $viewPath;
    }

    public function protectToggleAction()
    {
        $controller = $this->getController();
        if ($controller->request->getParam('action') !== 'toggle') {
            return;
        }
        if (!$controller->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $controller->Security->setConfig('validatePost', false);
    }
}
