<?php

use Phinx\Seed\AbstractSeed;

class GroupsSeed extends AbstractSeed
{

    public $records = array(
  array('id' => '1','name' => 'admin','sortorder' => '999999','data' => NULL,'modified' => '2017-04-10 19:41:12','created' => '2011-01-19 06:32:03'),
  array('id' => '2','name' => 'users','sortorder' => '999999','data' => NULL,'modified' => '2017-04-10 19:41:12','created' => '2011-01-19 06:32:15'),
  array('id' => '3','name' => 'visitors','sortorder' => '999999','data' => NULL,'modified' => '2017-04-10 19:41:12','created' => '2011-01-19 07:03:54')
);


    public function run()
    {
        $Table = $this->table('groups');
        $Table->insert($this->records)->save();
    }
}
