<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class ZipcodesInitialMigration extends AbstractMigration
{
    public function up()
    {

    $this->table('zipcodes',['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'string', [ 'default' => null, 'limit' => 20, 'null' => false, ]) 
        ->addColumn('city', 'string', [ 'default' => null, 'limit' => 100, 'null' => true, ])
        ->addColumn('state', 'string', [ 'default' => null, 'limit' => 5, 'null' => true, ])
        ->addColumn('state_name', 'string', [ 'default' => null, 'limit' => 150, 'null' => true, ])
        ->addColumn('country_iso2', 'string', [ 'default' => null, 'limit' => 10, 'null' => true, ])
        ->addColumn('country_iso3', 'string', [ 'default' => null, 'limit' => 10, 'null' => true, ])
        ->addColumn('country_name', 'string', [ 'default' => null, 'limit' => 150, 'null' => true, ])
        ->addColumn('lat', 'float', [ 'default' => null, 'null' => true, ])
        ->addColumn('lng', 'float', [ 'default' => null, 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'city', ] )
        ->addIndex( [ 'state', ] )
        ->addIndex( [ 'state_name', ] )
        ->addIndex( [ 'country_iso2', ] )
        ->addIndex( [ 'country_iso3', ] )
        ->addIndex( [ 'lat', ] )
        ->addIndex( [ 'lng', ] )
        ->create();
    }

    public function down()
    {
        $this->table('zipcodes')->drop()->save();
    }
}
