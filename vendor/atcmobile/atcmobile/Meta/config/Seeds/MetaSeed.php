<?php

use Phinx\Seed\AbstractSeed;

class MetaSeed extends AbstractSeed
{

    public $records = [

        [
            'model' => '',
            'key' => 'meta_description',
            'value' => 'ATC Mobile CMS',
            'created_by' => 1,
        ],
        [
            'model' => '',
            'key' => 'meta_generator',
            'value' => 'ATC Mobile CMS',
            'created_by' => 1,
        ],
        [
            'model' => '',
            'key' => 'meta_robots',
            'value' => 'index, follow',
            'created_by' => 1,
        ],
        [
            'model' => 'Atcmobapp/Nodes.Nodes',
            'foreign_key' => '1',
            'key' => 'meta_keywords',
            'value' => 'key1, key2',
            'created_by' => 1,
        ],
    ];

    public function run()
    {
        $Table = $this->table('meta');
        $Table->insert($this->records)->save();
    }

}
