<?php

use Phinx\Seed\AbstractSeed;

class LinksSeed extends AbstractSeed
{

    public $records = [
        [
            'id' => '5',
            'parent_id' => null,
            'menu_id' => '4',
            'title' => 'About',
            'class' => 'about',
            'description' => '',
            'link' => 'plugin:Atcmobapp%2fNodes/controller:Nodes/action:view/type:page/slug:about',
            'target' => '',
            'rel' => '',
            'status' => '1',
            'lft' => '3',
            'rght' => '4',
            'visibility_roles' => '',
            'params' => '',
            'created_by' => 1,
        ],
        [
            'id' => '6',
            'parent_id' => null,
            'menu_id' => '4',
            'title' => 'Contact',
            'class' => 'contact',
            'description' => '',
            'link' => 'plugin:Atcmobapp%2fContacts/controller:Contacts/action:view/contact',
            'target' => '',
            'rel' => '',
            'status' => '1',
            'lft' => '5',
            'rght' => '6',
            'visibility_roles' => '',
            'params' => '',
            'created_by' => 1,
        ],
        [
            'id' => '7',
            'parent_id' => null,
            'menu_id' => '3',
            'title' => 'Home',
            'class' => 'home',
            'description' => '',
            'link' => 'plugin:Atcmobapp%2fNodes/controller:Nodes/action:promoted',
            'target' => '',
            'rel' => '',
            'status' => '1',
            'lft' => '5',
            'rght' => '6',
            'visibility_roles' => '',
            'params' => '',
            'created_by' => 1,
        ],
        [
            'id' => '8',
            'parent_id' => null,
            'menu_id' => '3',
            'title' => 'About',
            'class' => 'about',
            'description' => '',
            'link' => 'plugin:Atcmobapp%2fNodes/controller:Nodes/action:view/type:page/slug:about',
            'target' => '',
            'rel' => '',
            'status' => '1',
            'lft' => '7',
            'rght' => '10',
            'visibility_roles' => '',
            'params' => '',
            'created_by' => 1,
        ],
        [
            'id' => '9',
            'parent_id' => '8',
            'menu_id' => '3',
            'title' => 'Child link',
            'class' => 'child-link',
            'description' => '',
            'link' => '#',
            'target' => '',
            'rel' => '',
            'status' => '0',
            'lft' => '8',
            'rght' => '9',
            'visibility_roles' => '',
            'params' => '',
            'created_by' => 1,
        ],
        [
            'id' => '10',
            'parent_id' => null,
            'menu_id' => '5',
            'title' => 'Site Admin',
            'class' => 'site-admin',
            'description' => '',
            'link' => '/admin',
            'target' => '',
            'rel' => '',
            'status' => '1',
            'lft' => '1',
            'rght' => '2',
            'visibility_roles' => '["2","3"]',
            'params' => '',
            'created_by' => 1,
        ],
        [
            'id' => '11',
            'parent_id' => null,
            'menu_id' => '5',
            'title' => 'Log out',
            'class' => 'log-out',
            'description' => '',
            'link' => '/plugin:Atcmobapp%2fUsers/controller:Users/action:logout',
            'target' => '',
            'rel' => '',
            'status' => '1',
            'lft' => '7',
            'rght' => '8',
            'visibility_roles' => '["1","3","4","5"]',
            'params' => '',
            'created_by' => 1,
        ],
        [
            'id' => '12',
            'parent_id' => null,
            'menu_id' => '6',
            'title' => 'Atcmobapp',
            'class' => 'atcmobile',
            'description' => '',
            'link' => 'http://metroeconomics.com',
            'target' => '',
            'rel' => '',
            'status' => '1',
            'lft' => '3',
            'rght' => '4',
            'visibility_roles' => '',
            'params' => '',
            'created_by' => 1,
        ],
        [
            'id' => '15',
            'parent_id' => null,
            'menu_id' => '3',
            'title' => 'Contact',
            'class' => 'contact',
            'description' => '',
            'link' => '/plugin:Atcmobapp%2fContacts/controller:Contacts/action:view/contact',
            'target' => '',
            'rel' => '',
            'status' => '1',
            'lft' => '11',
            'rght' => '12',
            'visibility_roles' => '',
            'params' => '',
            'created_by' => 1,
        ],
        [
            'id' => '16',
            'parent_id' => null,
            'menu_id' => '5',
            'title' => 'Entries (RSS)',
            'class' => 'entries-rss',
            'description' => '',
            'link' => 'plugin:Atcmobapp%2fNodes/controller:Nodes/action:feed/_ext:rss',
            'target' => '',
            'rel' => '',
            'status' => '1',
            'lft' => '3',
            'rght' => '4',
            'visibility_roles' => '',
            'params' => '',
            'created_by' => 1,
        ],
        [
            'id' => '17',
            'parent_id' => null,
            'menu_id' => '5',
            'title' => 'Comments (RSS)',
            'class' => 'comments-rss',
            'description' => '',
            'link' => 'plugin:Atcmobapp%2fComments/controller:Comments/action:index/_ext:rss',
            'target' => '',
            'rel' => '',
            'status' => '0',
            'lft' => '5',
            'rght' => '6',
            'visibility_roles' => '',
            'params' => '',
            'created_by' => 1,
        ],
    ];

    public function getDependencies()
    {
        return [
            'MenusSeed',
        ];
    }

    public function run()
    {
        $Table = $this->table('links');
        $Table->insert($this->records)->save();
    }
}