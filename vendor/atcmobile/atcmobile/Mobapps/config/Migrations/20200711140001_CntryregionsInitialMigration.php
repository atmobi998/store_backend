<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class CntryregionsInitialMigration extends AbstractMigration
{
    public function up()
    {

        $this->table('cntryregions')
        ->addColumn('region_name', 'string', [ 'default' => null, 'limit' => 100, 'null' => false, ])
        ->addColumn('region_description', 'string', [ 'default' => null, 'limit' => 100, 'null' => false, ])
        ->addColumn('bbox', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('extent', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('swlat', 'float', [ 'default' => NULL, 'null' => true, ])
        ->addColumn('swlon', 'float', [ 'default' => NULL, 'null' => true, ])
        ->addColumn('nelat', 'float', [ 'default' => NULL, 'null' => true, ])
        ->addColumn('nelon', 'float', [ 'default' => NULL, 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified') 
        ->addIndex( [ 'region_name', ] )      
        ->addIndex( [ 'swlat', ] )      
        ->addIndex( [ 'swlon', ] )      
        ->addIndex( [ 'nelat', ] )      
        ->addIndex( [ 'nelon', ] )      
        ->create();
    }

    public function down()
    {
        $this->table('cntryregions')->drop()->save();
    }
}
