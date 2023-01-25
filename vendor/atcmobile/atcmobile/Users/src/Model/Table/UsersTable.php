<?php

namespace Atcmobapp\Users\Model\Table;

use Cake\Core\Configure;
use Cake\Mailer\MailerAwareTrait;
use Cake\ORM\Query;
use Cake\Utility\Security;
use Cake\Validation\Validator;
use Atcmobapp\Core\Atcmobapp;
use Atcmobapp\Core\Model\Table\AtcmobappTable;
use Atcmobapp\Users\Model\Entity\User;

class UsersTable extends AtcmobappTable
{

    use MailerAwareTrait;

    protected $_displayFields = [
        'username',
        'name',
        'role.title' => 'Role',
        'email',
        'status' => ['type' => 'boolean'],
    ];

    protected $_editFields = [
        'role_id',
        'username',
        'name',
        'email',
        'website',
        'status',
    ];

    public $filterArgs = [
        'name' => ['type' => 'like', 'field' => ['Users.name', 'Users.username']],
        'role_id' => ['type' => 'value'],
    ];

    public function initialize(array $config)
    {
        $multiRole = Configure::read('Access Control.multiRole');

        if ($multiRole) {
            $this->belongsToMany('Atcmobapp/Users.Roles', [
                'through' => 'Atcmobapp/Users.RolesUsers',
                'strategy' => 'subquery',
            ]);
            unset($this->_displayFields['role.title']);
        } else {
            $this->belongsTo('Atcmobapp/Users.Roles');
        }

        $this->addBehavior('Acl.Acl', [
            'className' => 'Atcmobapp/Core.AtcmobappAcl',
            'type' => 'requester'
        ]);
        $this->addBehavior('Search.Search');
        $this->addBehavior('Timestamp');
        $this->addBehavior('Atcmobapp/Core.Trackable');
        $this->addBehavior('Atcmobapp/Core.Cached', [
            'groups' => ['users']
        ]);

        $this->getEventManager()->on($this->getMailer('Atcmobapp/Users.User'));

        $this->searchManager()
            ->add('name', 'Search.Like', [
                'field' => ['Users.name', 'Users.username', 'Users.email'],
                'before' => true,
                'after' => true,
            ]);

        if ($multiRole) {
            $this->searchManager()
                ->add('role_id', 'Search.Finder', [
                    'finder' => 'filterMultiRoles',
                ]);
        } else {
            $this->searchManager()
                ->value('role_id');
        }
    }

    /**
     * Used to register a new user
     *
     * @param User $user
     * @param array $data
     * @return bool|User
     */
    public function register(User $user, array $data)
    {
        $user = $this->patchEntity($user, $data, [
            'fieldList' => [
                'username',
                'website',
                'name',
                'password',
                'email'
            ]
        ]);

        $user->set([
            'role_id' => $this->Roles->byAlias('registered'),
            'activation_key' => $this->generateActivationKey(),
        ]);

        if (!$this->save($user)) {
            return false;
        }

        $this->dispatchEvent('Model.Users.registered', [
            'user' => $user
        ]);

        return $user;
    }

    /**
     * Activate the user
     *
     * @param User $user
     * @return bool|User
     */
    public function activate(User $user)
    {
        $user->activation_key = null;
        $user->status = true;

        $this->dispatchEvent('Model.Users.beforeActivation', [
            'user' => $user,
        ]);

        if (!$this->save($user)) {
            return false;
        }

        $this->dispatchEvent('Model.Users.activated', [
            'user' => $user
        ]);

        return $user;
    }

    /**
     * Starts an password reset procedure and sets out an email to the user
     *
     * @param User $user User to run the procedure for
     * @return bool Returns true when successful, false if not
     */
    public function resetPassword(User $user, array $options = [])
    {
        // Generate a unique activation key
        $user->activation_key = $this->generateActivationKey();

        Atcmobapp::dispatchEvent('Model.Users.beforeResetPassword',
            $this,
            compact('user')
        );
        $user = $this->save($user);
        if (!$user) {
            return false;
        }

        // Send out an password reset email
        $email = $this
            ->getMailer('Atcmobapp/Users.User')
            ->viewVars(compact('options'))
            ->send('resetPassword', [$user]);
        if (!$email) {
            return false;
        }

        Atcmobapp::dispatchEvent('Model.Users.afterResetPassword',
            $this,
            compact('email', 'user')
        );

        return true;
    }

    public function sendActivationEmail($user)
    {
        $email = $this->getMailer('Atcmobapp/Users.User')
            ->viewVars(compact('user'))
            ->send('registrationActivation', [$user]);

        Atcmobapp::dispatchEvent('Model.Users.afterActivationEmail',
            $this,
            compact('email', 'user')
        );
    }

    public function changePasswordFromReset(User $user, array $data)
    {
        $user = $this->patchEntity($user, $data, [
            'fieldList' => [
                'password',
                'verify_password',
            ]
        ]);
        if ($user->errors()) {
            return $user;
        }

        $user->activation_key = null;

        return $user;
    }

    public function validationDefault(Validator $validator)
    {
        return $validator
            ->add('username', [
                'notBlank' => [
                    'rule' => 'notBlank',
                    'message' => 'The username has already been taken.',
                    'last' => true
                ],
                'validateUnique' => [
                    'rule' => 'validateUnique',
                    'provider' => 'table',
                    'message' => 'The username has already been taken.',
                    'last' => true
                ]
            ])
            ->add('email', [
                'notEmpty' => [
                    'rule' => 'notBlank',
                    'message' => 'The username has already been taken.',
                    'last' => true
                ],
                'email' => [
                    'rule' => 'email',
                    'message' => 'Please provide a valid email address.',
                    'last' => true
                ]
            ])
            ->add('password', [
                'minLength' => [
                    'rule' => ['minLength', 6],
                    'message' => 'Passwords must be at least 6 characters long.',
                    'last' => true
                ],
                'compareWith' => [
                    'rule' => ['compareWith', 'verify_password'],
                    'message' => 'Passwords do not match. Please, try again',
                    'last' => true
                ]
            ])
            ->add('name', [
                'notBlank' => [
                    'rule' => 'notBlank',
                    'message' => 'This field cannot be left blank.',
                    'last' => true
                ],
                'name' => [
                    'rule' => ['custom', '/^[-\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}_\[\]\(\) ]+$/mu'],
                    'message' => 'This field must be alphanumeric',
                    'last' => true
                ]
            ])
            ->allowEmpty('website')
            ->add('website', [
                'url' => [
                    'rule' => 'url',
                    'message' => 'This field must be a valid URL',
                    'last' => true
                ]
            ]);
    }

    public function findFilterMultiRoles(Query $query, array $options)
    {
        $roleId = isset($options['role_id']) ? $options['role_id'] : false;
        $query
            ->where([
                $this->aliasField('role_id') => $roleId,
            ])
            ->orWhere([
                $this->Roles->aliasField('id') => $roleId,
            ]);

        return $query;
    }

    public function generateActivationKey($length = null)
    {
        if (!$length) {
            $length = Configure::read('Atcmobapp.activationKeyLength', 20);
        }

        return bin2hex(Security::randomBytes($length));
    }

    public function findAuthUser(Query $query, array $options)
    {
        return $query
            ->where([$this->aliasField('status') => 1]);
    }
}
