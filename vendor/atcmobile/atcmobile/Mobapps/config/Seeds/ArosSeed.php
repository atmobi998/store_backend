<?php

use Phinx\Seed\AbstractSeed;

class ArosSeed extends AbstractSeed
{

    public $records = array();

    public function run()
    {
        $Table = $this->table('aros');
        $Table->insert($this->records)->save();
    }
}
