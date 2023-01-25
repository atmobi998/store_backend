<?php use Cake\Routing\Router;

echo __d('atcmobapp', 'Hello %s', $user->name); ?>,

<?php
echo __d('atcmobapp', 'Please visit this link to activate your account: %s', Router::url(['prefix' => false, 'plugin' => 'Atcmobapp/Users', 'controller' => 'Users', 'action' => 'activate', $user->username, $user->activation_key], true));
