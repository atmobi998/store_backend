<?php

namespace Atcmobapp\Mobapps\Controller\Api;

use Cake\Controller\Component\AuthComponent;
use Cake\Controller\Controller;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\Event;
use \Firebase\JWT\JWT;


/**
 * Base Api Controller
 *
 */
class AppController extends Controller
{

    protected function setupAuthConfig()
    {
        $authConfig = [
            'authenticate' => [
                AuthComponent::ALL => [
                    'userModel' => 'Atcmobapp/Users.Users',
                    'fields' => [
                        'username' => 'username',
                        'password' => 'password',
                    ],
                    'passwordHasher' => [
                        'className' => 'Fallback',
                        'hashers' => ['Default', 'Weak'],
                    ],
                    'scope' => [
                        'Users.status' => true,
                    ],
                ],
                'Atcmobapp/Acl.ApiForm',
            ],
            'authorize' => [
                AuthComponent::ALL => [
                    'actionPath' => 'controllers',
                    'userModel' => 'Atcmobapp/Users.Users',
                ],
                'Atcmobapp/Acl.AclCached' => [
                    'actionPath' => 'controllers',
                ]
            ],

            'unauthorizedRedirect' => false,
            'checkAuthInd' => 'Controller.initialize',
            'loginAction' => false,
        ];
        if (Plugin::isLoaded('ADmad/JwtAuth')) {
		$authConfig['authenticate']['ADmad/JwtAuth.Jwt'] = [
			'fields' => [
			    'username' => 'id',
			],
			'parameter' => 'token',
			'queryDatasource' => true,
		];
	}
        return $authConfig;
    }

    /**
     * Initialize
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        $this->loadComponent('Auth', $this->setupAuthConfig());
        $this->loadComponent('RequestHandler');
        Configure::write('debug', false);
    }

    /**
     * beforeFilter
     *
     * @return void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        if (Configure::read('Site.status') == 0 && $this->Auth->user('role_id') != 1) {
            if (!$this->getRequest()->is('whitelisted')) {
                $this->response->statusCode(503);
            }
        }
	
    }
}