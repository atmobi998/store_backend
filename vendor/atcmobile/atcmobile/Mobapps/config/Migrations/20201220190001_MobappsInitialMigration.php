<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class MobappsInitialMigration extends AbstractMigration
{
    public function up()
    {

    $this->table('mobapps',['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'string', [ 'default' => null, 'limit' => 100, 'null' => false, ]) 
        ->addColumn('app_name', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('app_desc', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('gleapp_id', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('gleapp_url', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('aplapp_id', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('aplapp_url', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'app_name', ] )
        ->addIndex( [ 'gleapp_id', ] )
        ->addIndex( [ 'aplapp_id', ] )
        ->create();
    }

    public function down()
    {
        $this->table('mobapps')->drop()->save();
    }
}
