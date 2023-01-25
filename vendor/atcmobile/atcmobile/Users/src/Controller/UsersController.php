<?php

namespace Atcmobapp\Users\Controller;

use Atcmobapp\Core\Atcmobapp;
use Atcmobapp\Users\Model\Table\UsersTable;

/**
 * Users Controller
 *
 * @property UsersTable Users
 * @category Controller
 * @package  Atcmobapp.Users.Controller
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class UsersController extends AppController
{

    /**
     * {inheritdoc}
     */
    public function initialize()
    {
        parent::initialize();
        $this->Auth->allow(['logout']);
    }

    /**
     * Index
     *
     * @return void
     * @access public
     */
    public function index()
    {
        $this->set('title_for_layout', __d('atcmobile', 'Users'));
    }

    /**
     * Add
     *
     * @return void
     * @access public
     */
    public function add()
    {
        $user = $this->Users->newEntity();

        $this->set('user', $user);

        if (!$this->getRequest()->is('post')) {
            return;
        }

        $user = $this->Users->register($user, $this->getRequest()->getData());
        if (!$user) {
            $this->Flash->error(__d('atcmobile', 'The User could not be saved. Please, try again.'));

            return;
        }

        $this->Flash->success(__d('atcmobile', 'You have successfully registered an account. An email has been sent with further instructions.'));

        return $this->redirect(['action' => 'login']);
    }

    /**
     * Activate
     *
     * @param string $username
     * @param string $activationKey
     * @return \Cake\Http\Response|void
     * @access public
     */
    public function activate($username, $activationKey)
    {
        // Get the user with the activation key from the database
        $user = $this->Users
            ->find()
            ->where([
                'username' => $username,
                'activation_key' => $activationKey
            ])
            ->first();
        if (!$user) {
            $this->Flash->error(__d('atcmobile', 'Could not activate your account.'));

            return $this->redirect(['action' => 'login']);
        }

        // Activate the user
        $user = $this->Users->activate($user);
        if (!$user) {
            $this->Flash->error(__d('atcmobile', 'Could not activate your account'));

            return $this->redirect(['action' => 'login']);
        }

        $this->Flash->success(__d('atcmobile', 'Account activated successfully.'));

        return $this->redirect(['action' => 'login']);
    }

    /**
     * Edit
     *
     * @return void
     * @access public
     */
    public function edit()
    {
    }

    /**
     * Forgot
     *
     * @return void
     * @access public
     */
    public function forgot()
    {
        if (!$this->getRequest()->is('post')) {
            return;
        }

        $user = $this->Users
            ->findByUsername($this->getRequest()->data('username'))
            ->first();
        if (!$user) {
            $this->Flash->error(__d('atcmobile', 'Invalid username.'));

            return $this->redirect(['action' => 'forgot']);
        }

        if (empty($user->email)) {
            $this->Flash->error(__d('atcmobile', 'Invalid email.'));

            return;
        }

        $options = [
            'prefix' => $this->getRequest()->getParam('prefix'),
        ];
        $success = $this->Users->resetPassword($user, $options);
        if (!$success) {
            $this->Flash->error(__d('atcmobile', 'An error occurred. Please try again.'));

            return;
        }

        $this->Flash->success(__d('atcmobile', 'An email has been sent with instructions for resetting your password.'));

        return $this->redirect(['action' => 'login']);
    }

    /**
     * Reset
     *
     * @param string $username
     * @param string $activationKey
     * @return \Cake\Http\Response|void
     * @access public
     */
    public function reset($username, $activationKey)
    {
        // Get the user with the activation key from the database
        $user = $this->Users->find()->where([
            'username' => $username,
            'activation_key' => $activationKey
        ])->first();
        if (!$user) {
            $this->Flash->error(__d('atcmobile', 'An error occurred.'));

            return $this->redirect(['action' => 'login']);
        }

        $this->set('user', $user);

        if (!$this->getRequest()->is('put')) {
            return;
        }

        // Change the password of the user entity
        $user = $this->Users->changePasswordFromReset($user, $this->getRequest()->getData());

        // Save the user with changed password
        $user = $this->Users->save($user);
        if (!$user) {
            $this->Flash->error(__d('atcmobile', 'An error occurred. Please try again.'));

            return;
        }

        $this->Flash->success(__d('atcmobile', 'Your password has been reset successfully.'));

        return $this->redirect(['action' => 'login']);
    }

    /**
     * Login
     *
     * @return \Cake\Http\Response|void
     * @access public
     */
    public function login()
    {
        $session = $this->getRequest()->session();
        if (!$this->getRequest()->is('post')) {
            $redirectUrl = $this->Auth->redirectUrl();
            if ($redirectUrl != '/' && !$session->check('Atcmobapp.redirect')) {
                $session->write('Atcmobapp.redirect', $redirectUrl);
            }

            return;
        }

        Atcmobapp::dispatchEvent('Controller.Users.beforeLogin', $this);

        $user = $this->Auth->identify();
        if (!$user) {
            Atcmobapp::dispatchEvent('Controller.Users.loginFailure', $this);

            $this->Flash->error($this->Auth->config('authError'));

            return $this->redirect($this->Auth->loginAction);
        }

        if ($session->check('Atcmobapp.redirect')) {
            $redirectUrl = $session->read('Atcmobapp.redirect');
            $session->delete('Atcmobapp.redirect');
        } else {
            $redirectUrl = $this->Auth->redirectUrl();
        }

        if (!$this->Access->isUrlAuthorized($user, $redirectUrl)) {
            Atcmobapp::dispatchEvent('Controller.Users.loginFailure', $this);
            $this->Auth->config('authError', __d('atcmobile', 'Authorization error'));
            $this->Flash->error($this->Auth->config('authError'));

            return $this->redirect($this->Auth->loginRedirect);
        }

        $this->Auth->setUser($user);

        Atcmobapp::dispatchEvent('Controller.Users.loginSuccessful', $this);

        return $this->redirect($redirectUrl);
    }

    /**
     * Logout
     *
     * @access public
     */
    public function logout()
    {
        Atcmobapp::dispatchEvent('Controller.Users.beforeLogout', $this);
        $this->getRequest()->session()->delete('Atcmobapp.redirect');

        $this->Flash->success(__d('atcmobile', 'Log out successful.'), 'auth');

        $logoutUrl = $this->Auth->logout();
        Atcmobapp::dispatchEvent('Controller.Users.afterLogout', $this);

        return $this->redirect($logoutUrl);
    }

    /**
     * View
     *
     * @param string $username
     * @return \Cake\Http\Response|void
     * @access public
     */
    public function view($username = null)
    {
        if ($username == null) {
            $username = $this->Auth->user('username');
        }
        $user = $this->Users->findByUsername($username)->first();
        if (!$user) {
            $this->Flash->error(__d('atcmobile', 'Invalid User.'));

            return $this->redirect('/');
        }
        $this->set('title_for_layout', $user->name);
        $this->set(compact('user'));
    }

    protected function _getSenderEmail()
    {
        return 'atcmobile@' . preg_replace('#^www\.#', '', strtolower($_SERVER['SERVER_NAME']));
    }
}
