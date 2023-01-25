<?php

use Cake\Cache\Cache;
use Cake\Core\App;
use Cake\Core\Configure;
use Atcmobapp\Core\Atcmobapp;

if (Configure::read('Site.acl_plugin') == 'Atcmobapp/Acl') {
    // activate AclFilter component only until after a succesfull install
    if (Configure::read('Atcmobapp.installed')) {
        Atcmobapp::hookComponent('*', 'Atcmobapp/Acl.Filter');
        Atcmobapp::hookComponent('*', 'Atcmobapp/Acl.Access');
    }

    Atcmobapp::hookBehavior('Atcmobapp/Users.Users', 'Atcmobapp/Acl.UserAro', ['priority' => 20]);
    Atcmobapp::hookBehavior('Atcmobapp/Users.Roles', 'Atcmobapp/Acl.RoleAro', ['priority' => 20]);

    $defaultCacheConfig = Configure::read('Atcmobapp.Cache.defaultConfig');
    Cache::setConfig('permissions', [
        'duration' => '+1 hour',
        'path' => CACHE . 'acl' . DS,
        'groups' => ['acl']
    ] + $defaultCacheConfig);

    if (Configure::read('Access Control.multiRole')) {
        Configure::write('Acl.classname', App::className('Atcmobapp/Acl.HabtmDbAcl', 'Adapter'));
    }
}
