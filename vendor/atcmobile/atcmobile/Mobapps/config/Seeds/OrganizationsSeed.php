<?php

use Phinx\Seed\AbstractSeed;

class OrganizationsSeed extends AbstractSeed
{

    public $records = array(
);

    public function run()
    {
        $Table = $this->table('organizations');
        $Table->insert($this->records)->save();
    }
}
