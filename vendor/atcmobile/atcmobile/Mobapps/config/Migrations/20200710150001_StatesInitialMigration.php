<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class StatesInitialMigration extends AbstractMigration
{
    public function up()
    {

        $this->table('states',['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'string', [ 'default' => null, 'limit' => 10, 'null' => false, ]) 
        ->addColumn('state_name', 'string', [ 'default' => null, 'limit' => 100, 'null' => false, ])
        ->addColumn('country_iso3', 'string', [ 'default' => null, 'limit' => 10, 'null' => false, ])
        ->addColumn('region_id', 'integer', ['limit' => 10, 'null' => false, ])
        ->addColumn('display_order', 'integer', ['limit' => 10, 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'id', ] )      
        ->addIndex( [ 'state_name', ] )      
        ->addIndex( [ 'country_iso3', ] )      
        ->addIndex( [ 'display_order', ] )      
        ->create();
    }

    public function down()
    {
        $this->table('states')->drop()->save();
    }
}
