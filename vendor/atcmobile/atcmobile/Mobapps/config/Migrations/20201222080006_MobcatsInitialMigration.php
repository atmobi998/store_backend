<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class MobcatsInitialMigration extends AbstractMigration
{
    public function up()
    {

    $this->table('mobcats',['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false, 'identity' => true ])
        ->addColumn('store_id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false ])
        ->addColumn('name', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('slug', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('description', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => '', 'null' => true, ])
        ->addColumn('sort', 'integer', [ 'default' => 1, 'null' => true, ])
        ->addColumn('active', 'integer', [ 'default' => 1, 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'store_id', ] )
        ->addIndex( [ 'name', ] )
        ->addIndex( [ 'slug', ] )
        ->addIndex( [ 'sort', ] )
        ->addIndex( [ 'active', ] )
        ->create();
    }

    public function down()
    {
        $this->table('mobcats')->drop()->save();
    }
}
