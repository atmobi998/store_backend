<?php

use Cake\Cache\Cache;
use Cake\Core\Configure;
use Atcmobapp\Core\Atcmobapp;

Cache::setConfig('atcmobile_comments', array_merge(
    Configure::read('Atcmobapp.Cache.defaultConfig'),
    ['groups' => ['comments']]
));

Atcmobapp::hookHelper('*', 'Atcmobapp/Comments.Comments');

Atcmobapp::hookBehavior('Atcmobapp/Nodes.Nodes', 'Atcmobapp/Comments.Commentable');
