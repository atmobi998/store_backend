<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Atcmobapp\Core\Atcmobapp;

Atcmobapp::hookApiComponent('Atcmobapp/Users.Users', 'Users.UserApi');

/**
 * Failed login attempts
 *
 * Default is 5 failed login attempts in every 5 minutes
 */
$cacheConfig = array_merge(
    Configure::read('Atcmobapp.Cache.defaultConfig'),
    ['groups' => ['users']]
);
$failedLoginDuration = 300;
Configure::write('User.failed_login_limit', 5);
Configure::write('User.failed_login_duration', $failedLoginDuration);
Cache::setConfig('users_login', array_merge($cacheConfig, [
    'duration' => '+' . $failedLoginDuration . ' seconds',
    'groups' => ['users'],
]));

Atcmobapp::hookAdminRowAction('Atcmobapp/Users.Admin/Users/index', 'Reset Password', [
    'prefix:admin/plugin:Atcmobapp%2fUsers/controller:users/action:reset_password/:id' => [
        'title' => false,
        'options' => [
            'icon' => 'unlock',
            'tooltip' => [
                'data-title' => __d('atcmobile', 'Reset password'),
            ],
        ],
    ],
]);

Atcmobapp::hookComponent('*', 'Atcmobapp/Users.LoggedInUser');
