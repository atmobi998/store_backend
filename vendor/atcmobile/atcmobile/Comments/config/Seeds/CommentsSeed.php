<?php

use Phinx\Seed\AbstractSeed;

class CommentsSeed extends AbstractSeed
{

    public $records = [
        [
            'id' => '1',
            'parent_id' => null,
            'model' => 'Atcmobapp/Nodes.Nodes',
            'foreign_key' => '1',
            'name' => 'ATC Mobile',
            'email' => 'hotranan@gmail.com',
            'website' => 'http://metroeconomics.com',
            'ip' => '127.0.0.1',
            'title' => '',
            'body' => 'Hi, this is the first comment.',
            'rating' => null,
            'status' => '1',
            'notify' => '0',
            'type' => 'blog',
            'comment_type' => 'comment',
            'lft' => '1',
            'rght' => '2',
        ],
    ];

    public function run()
    {
        $Table = $this->table('comments');
        $Table->insert($this->records)->save();
    }
}
