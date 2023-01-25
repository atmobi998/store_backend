<?php

use Phinx\Seed\AbstractSeed;

class NodesSeed extends AbstractSeed
{

    public $records = [
        [
            'id' => '1',
            'parent_id' => null,
            'user_id' => '1',
            'created_by' => '1',
            'title' => 'Hello',
            'slug' => 'hello',
            'body' => '<p>Welcome to ATC Mobile.</p>',
            'excerpt' => '',
            'status' => '1',
            'mime_type' => '',
            'comment_status' => '2',
            'comment_count' => '1',
            'promote' => '1',
            'path' => '/blog/hello',
            'terms' => '{"1":"uncategorized"}',
            'sticky' => '0',
            'lft' => '1',
            'rght' => '2',
            'visibility_roles' => '',
            'type' => 'blog',
        ],
        [
            'id' => '2',
            'parent_id' => null,
            'user_id' => '1',
            'created_by' => '1',
            'title' => 'About',
            'slug' => 'about',
            'body' => '<p>This is an example of a ATC CMS page.</p>',
            'excerpt' => '',
            'status' => '1',
            'mime_type' => '',
            'comment_status' => '0',
            'comment_count' => '0',
            'promote' => '0',
            'path' => '/about',
            'terms' => '',
            'sticky' => '0',
            'lft' => '1',
            'rght' => '2',
            'visibility_roles' => '',
            'type' => 'page',
        ],
    ];

    public function run()
    {
        $Table = $this->table('nodes');
        $Table->insert($this->records)->save();
    }
}
