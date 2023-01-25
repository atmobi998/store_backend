<?php

namespace Atcmobapp\Users\Shell;

use Cake\Core\Configure;
use Cake\Console\Shell;
use Atcmobapp\Users\Model\Entity\User;

/**
 * UsersShell
 *
 * @package Atcmobapp.Users.Shell
 */
class UsersShell extends Shell
{

    public $uses = [
        'Users.User',
    ];

    /**
     * Initialize
     */
    public function initialize()
    {
        Configure::write('Trackable.Auth.User', ['id' => 1]);
        $this->loadModel('Atcmobapp/Users.Users');
    }

    /**
     * getOptionParser
     */
    public function getOptionParser()
    {
        return parent::getOptionParser()
            ->addSubCommand('create', [
                'help' => __d('atcmobile', 'Create a new user'),
                'parser' => [
                    'arguments' => [
                        'username' => [
                            'required' => true,
                            'help' => __d('atcmobile', 'Username to reset'),
                        ],
                        'password' => [
                            'required' => true,
                            'help' => __d('atcmobile', 'New user password'),
                        ],
                        'role_id' => [
                            'required' => true,
                            'help' => __d('atcmobile', 'Role id for user'),
                        ],
                    ],
                ],
            ])
            ->addSubCommand('reset', [
                'help' => __d('atcmobile', 'Reset user password'),
                'parser' => [
                    'arguments' => [
                        'username' => [
                            'required' => true,
                            'help' => __d('atcmobile', 'Username to reset'),
                        ],
                        'password' => [
                            'required' => true,
                            'help' => __d('atcmobile', 'New user password'),
                        ],
                    ],
                ],
            ]);
    }

    /**
     * reset
     */
    public function reset()
    {
        $username = $this->args[0];
        $password = $this->args[1];

        $user = $this->Users->findByUsername($username)->first();
        if (empty($user)) {
            return $this->warn(__d('atcmobile', 'User \'%s\' not found', $username));
        }
        $user->clean();
        $user->password = $password;
        $result = $this->Users->save($user);
        if ($result) {
            $this->success(__d('atcmobile', 'Password for \'%s\' has been changed', $username));
        }
    }

    /**
     * reset
     */
    public function create()
    {
        $username = $this->args[0];
        $password = $this->args[1];
        $roleId = $this->args[2];

        $user = $this->Users->findByUsername($username)->first();
        if ($user) {
            return $this->warn(__d('atcmobile', 'User \'%s\' already exists', $username));
        }

        $user = new User([
            'username' => $username,
            'password' => $password,
            'role_id' => $roleId,
            'name' => $username,
            'email' => $username,
            'activation_key' => $this->Users->generateActivationKey(),
            'status' => true,
        ]);
        $result = $this->Users->save($user);
        if ($result) {
            $this->success(__d('atcmobile', 'User \'%s\' has been created', $username));
        }
    }

}
