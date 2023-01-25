<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class UrolesInitialMigration extends AbstractMigration
{
    public function up()
    {

        $this->table('uroles')
        ->addColumn('role', 'string', [ 'default' => null, 'limit' => 100, 'null' => false, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => false, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'role', ], ['unique' => true] )
        ->create();
    }

    public function down()
    {
        $this->table('uroles')->drop()->save();
    }
}
