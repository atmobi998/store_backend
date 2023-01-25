<?php

use Phinx\Seed\AbstractSeed;

class RescafcntsSeed extends AbstractSeed
{

    public $records = array();

    public function run()
    {
        $Table = $this->table('rescafcnts');
        $Table->insert($this->records)->save();
    }
}
