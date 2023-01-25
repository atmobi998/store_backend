<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class UserlogsInitialMigration extends AbstractMigration
{
    public function up()
    {

        $this->table('userlogs', ['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false, 'identity' => true ])
        ->addColumn('user_id', 'biginteger', [ 'default' => null, 'null' => false, ])
        ->addColumn('obj_id', 'biginteger', [ 'default' => null, 'null' => false, ])
        ->addColumn('obj_name', 'string', [ 'default' => null, 'limit' => 100, 'null' => true, ])
        ->addColumn('session_id', 'string', [ 'default' => null, 'limit' => 100, 'null' => true, ])
        ->addColumn('token', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => null, 'null' => true, ])
        ->addColumn('devinfo', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('mobapp', 'string', [ 'default' => null, 'limit' => 100, 'null' => true, ])
        ->addColumn('old_data', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => null, 'null' => true, ])
        ->addColumn('new_data', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => null, 'null' => true, ])
        ->addColumn('log_ip', 'string', [ 'default' => null, 'limit' => 50, 'null' => true, ])
        ->addColumn('log_iploc', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => null, 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'user_id', ] )
        ->addIndex( [ 'obj_id', ] )
        ->addIndex( [ 'obj_name', ] )
        ->addIndex( [ 'session_id', ] )
        ->addIndex( [ 'log_ip', ] )
        ->addIndex( [ 'mobapp', ] )
        ->addIndex( [ 'created', ] )
        ->addIndex( [ 'modified', ] )
        ->create();
    }

    public function down()
    {
        $this->table('userlogs')->drop()->save();
    }
}
