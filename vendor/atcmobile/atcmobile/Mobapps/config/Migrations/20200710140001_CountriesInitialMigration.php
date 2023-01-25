<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CountriesInitialMigration extends AbstractMigration
{
    public function up()
    {

        $this->table('countries',['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'string', [ 'default' => null, 'limit' => 10, 'null' => false, ]) 
        ->addColumn('country_name', 'string', [ 'default' => null, 'limit' => 100, 'null' => false, ])
        ->addColumn('country_printable_name', 'string', [ 'default' => null, 'limit' => 100, 'null' => false, ])
        ->addColumn('country_iso3', 'string', [ 'default' => null, 'limit' => 10, 'null' => false, ])
        ->addColumn('country_numcode', 'integer', ['limit' => 10, 'null' => false, ])
        ->addColumn('region_id', 'integer', ['limit' => 10, 'null' => false, ])
        ->addColumn('display_order', 'integer', ['limit' => 10, 'null' => false, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'id', ] )      
        ->addIndex( [ 'country_name', ] )      
        ->addIndex( [ 'country_iso3', ] )      
        ->addIndex( [ 'display_order', ] )      
        ->create();
    }

    public function down()
    {
        $this->table('countries')->drop()->save();
    }
}
