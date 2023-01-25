<?php

namespace Atcmobapp\Acl\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\Component\AuthComponent;
use Cake\Core\Configure;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use Atcmobapp\Core\Atcmobapp;
use Atcmobapp\Core\Utility\StringConverter;

/**
 * AclFilter Component
 *
 * @category Component
 * @package  Atcmobapp.Acl.Controller.Component
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class FilterComponent extends Component
{

    /**
     * _controller
     *
     * @var Controller
     */
    protected $_controller = null;

    /**
     * beforeFilter
     *
     * @param Event $event instance of event
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        $this->_controller = $event->getSubject();

        if ($this->_config('multiRole')) {
            Atcmobapp::hookAdminTab('Admin/Users/add', 'Roles', 'Atcmobapp/Acl.admin/roles');
            Atcmobapp::hookAdminTab('Admin/Users/edit', 'Roles', 'Atcmobapp/Acl.admin/roles');
        }
    }

    /**
     * Helper function to retrieve value from `Access Control` settings
     *
     * @return mixed null when config key is not found
     */
    protected function _config($key)
    {
        static $config = null;
        if (empty($config)) {
            $config = Configure::read('Access Control');
        }
        if (array_key_exists($key, (array)$config)) {
            return $config[$key];
        }

        return null;
    }

    /**
     * configure component settings
     *
     * @return void
     */
    protected function _configure()
    {
        if (!$this->_registry->has('Atcmobapp/Acl.AutoLogin')) {
            $this->_registry->load('Atcmobapp/Acl.AutoLogin');
            if (!$this->_registry->has('Cookie')) {
                $this->_registry->load('Cookie');
            }
        }

        //Configure AuthComponent
        $this->_controller->Auth->setConfig('authenticate', [
            AuthComponent::ALL => [
                'userModel' => 'Atcmobapp/Users.Users',
                'fields' => [
                    'username' => 'username',
                    'password' => 'password',
                ],
                'passwordHasher' => [
                    'className' => 'Fallback',
                    'hashers' => ['Default', 'Weak']
                ],
                'finder' => 'authUser',
            ],
        ]);
        if ($this->_config('autoLoginDuration')) {
            if (!function_exists('mcrypt_encrypt') && !function_exists('openssl_encrypt')) {
                $notice = __d('atcmobile', '"AutoLogin" (Remember Me) disabled since mcrypt_encrypt or openssl_encrypt is not available');
                $this->log($notice, LOG_CRIT);
                if ($this->_controller->request->getParam('prefix') == 'admin') {
                    $this->_controller->Flash->error($notice);
                }
                if (isset($this->_controller->Settings)) {
                    $Setting = $this->_controller->Settings;
                } else {
                    $Setting = TableRegistry::get('Atcmobapp/Settings.Settings');
                }
                $Setting->write('Access Control.autoLoginDuration', '');
            }
            $this->_controller->Auth->setConfig('authenticate', ['Atcmobapp/Acl.Cookie']);
        }
        if ($this->_config('multiColumn')) {
            $this->_controller->Auth->setConfig('authenticate', ['Atcmobapp/Acl.MultiColumn']);
        } else {
            $this->_controller->Auth->setConfig('authenticate', ['Form']);
        }

        $this->_controller->Auth->setConfig('authorize', [
            AuthComponent::ALL => [
                'actionPath' => 'controllers',
                'userModel' => 'Atcmobapp/Users.Users',
            ],
            'Atcmobapp/Acl.AclCached' => [
                'actionPath' => 'controllers',
            ]
        ]);

        if ($this->_controller->request->getParam('prefix') == 'admin' &&
            !$this->_controller->Auth->user()) {
            $this->_controller->Auth->setConfig('authError', false);
        }

        $this->configureLoginActions();
    }

    /**
     * Load login actions configurations
     *
     * @return void
     */
    public function configureLoginActions()
    {
        $this->_controller->Auth->setConfig('loginAction', [
            'prefix' => false,
            'plugin' => 'Atcmobapp/Users',
            'controller' => 'Users',
            'action' => 'login',
        ]);
        if ($this->request->getParam('prefix') === 'admin') {
            $this->_controller->Auth->setConfig('loginAction', [
                'prefix' => 'admin',
                'plugin' => 'Atcmobapp/Users',
                'controller' => 'Users',
                'action' => 'login',
            ]);
        }
        $this->_controller->Auth->setConfig('logoutRedirect', [
            'plugin' => 'Atcmobapp/Users',
            'controller' => 'Users',
            'action' => 'login',
        ]);
        if ($this->request->getParam('prefix') == 'admin') {
            $dashboardUrl = Configure::read('Site.dashboard_url');
            if (is_string($dashboardUrl)) {
                $converter = new StringConverter();
                $dashboardUrl = $converter->linkStringToArray($dashboardUrl);
            }
            $loginRedirect = $dashboardUrl ?: '/admin';
            $this->_controller->Auth->setConfig('loginRedirect', $loginRedirect);
        } else {
            $loginRedirect = Configure::read('Atcmobapp.homeUrl') ?: '/';
            $this->_controller->Auth->setConfig('loginRedirect', $loginRedirect);
        }

        if ($this->_controller->request->is('ajax')) {
            $this->_controller->Auth->setConfig('unauthorizedRedirect', false);
        } else {
            $this->_controller->Auth->setConfig('unauthorizedRedirect', [
                'plugin' => 'Atcmobapp/Users',
                'controller' => 'Users',
                'action' => 'login',
            ]);
        }

        $config = Configure::read('Acl');
        if (!empty($config['Auth']) && is_array($config['Auth'])) {
            $isAdminRequest = !empty($this->_controller->request->getParam('admin'));
            $authActions = [
                'loginAction',
                'loginRedirect',
                'logoutRedirect',
                'unauthorizedRedirect',
            ];
            foreach ($config['Auth'] as $property => $value) {
                $isAdminRoute = !empty($value['admin']);
                $isAuthAction = in_array($property, $authActions);
                if (!is_string($value) && $isAdminRequest !== $isAdminRoute && $isAuthAction) {
                    continue;
                }
                $this->_controller->Auth->config($property, $value);
            }
        }
    }

    /**
     * acl and auth
     *
     * @return void
     */
    public function auth()
    {
        $this->_configure();
        $user = $this->_controller->Auth->user();

        // authorization for authenticated user is handled by authorize object
        if ($user) {
            return;
        }

        $authorizer = $this->_controller->Auth->getAuthorize('Atcmobapp/Acl.AclCached');

        if ($this->_controller->Acl->check('Role-public', $authorizer->action($this->_controller->request))) {
            $this->_controller->Auth->allow(
                $this->_controller->request->getParam('action')
            );
        }
    }
}
