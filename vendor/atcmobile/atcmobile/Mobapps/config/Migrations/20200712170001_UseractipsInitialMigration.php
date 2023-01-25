<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class UseractipsInitialMigration extends AbstractMigration
{
    public function up()
    {

        $this->table('useractips', ['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false, 'identity' => true ])
        ->addColumn('action_ip', 'string', [ 'default' => null, 'limit' => 50, 'null' => true, ])
        ->addColumn('action_iploc', 'string', [ 'default' => null, 'limit' => 512, 'null' => true, ])
        ->addColumn('ip_from', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => true, ])
        ->addColumn('ip_to', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => true, ])
        ->addColumn('country_code', 'string', [ 'default' => null, 'limit' => 3, 'null' => true, ])
        ->addColumn('country_name', 'string', [ 'default' => null, 'limit' => 64, 'null' => true, ])
        ->addColumn('region_name', 'string', [ 'default' => null, 'limit' => 128, 'null' => true, ])
        ->addColumn('city_name', 'string', [ 'default' => null, 'limit' => 128, 'null' => true, ])
        ->addColumn('latitude', 'float', [ 'default' => null, 'null' => true, ])
        ->addColumn('longitude', 'float', [ 'default' => null, 'null' => true, ])
        ->addColumn('zip_code', 'string', [ 'default' => null, 'limit' => 30, 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => false, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'action_ip', ] )
        ->addIndex( [ 'action_iploc', ] )
        ->addIndex( [ 'ip_from', ] )
        ->addIndex( [ 'ip_to', ] )
        ->addIndex( [ 'country_code', ] )
        ->addIndex( [ 'region_name', ] )
        ->addIndex( [ 'city_name', ] )
        ->addIndex( [ 'latitude', ] )
        ->addIndex( [ 'longitude', ] )
        ->addIndex( [ 'zip_code', ] )
        ->addIndex( [ 'created', ] )
        ->addIndex( [ 'modified', ] )
        ->create();
    }

    public function down()
    {
        $this->table('useractips')->drop()->save();
    }
}
