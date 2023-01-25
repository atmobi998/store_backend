<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class GroupsInitialMigration extends AbstractMigration
{
    public function up()
    {

        $this->table('groups')
        ->addColumn('name', 'string', [ 'default' => null, 'limit' => 64, 'null' => false, ])
        ->addColumn('sortorder', 'integer', [ 'default' => 999999, 'limit' => 11, 'null' => true, ])
        ->addColumn('data', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM,  'default' => null, 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified') 
        ->addIndex( [ 'name', ] )      
        ->addIndex( [ 'sortorder', ] )      
        ->create();
    }

    public function down()
    {
        $this->table('groups')->drop()->save();
    }
}
