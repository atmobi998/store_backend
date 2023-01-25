<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class UseractionsInitialMigration extends AbstractMigration
{
    public function up()
    {

        $this->table('useractions', ['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false, 'identity' => true ])
        ->addColumn('user_id', 'biginteger', [ 'default' => null, 'null' => false, ])
        ->addColumn('session_id', 'string', [ 'default' => '', 'limit' => 100, 'null' => true, ])
        ->addColumn('action_name', 'string', [ 'default' => '', 'limit' => 100, 'null' => true, ])
        ->addColumn('action_ip', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
        ->addColumn('action_iploc', 'string', [ 'default' => '', 'limit' => 512, 'null' => true, ])
        ->addColumn('otp_code', 'string', [ 'default' => '', 'limit' => 20, 'null' => true, ])
        ->addColumn('token', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => null, 'null' => true, ])
        ->addColumn('devinfo', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('mobapp', 'string', [ 'default' => '', 'limit' => 100, 'null' => true, ])
        ->addColumn('erpt', 'integer', [ 'default' => 0, 'limit' => 1, 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'user_id', ] )
        ->addIndex( [ 'session_id', ] )
        ->addIndex( [ 'action_name', ] )
        ->addIndex( [ 'action_ip', ] )
        ->addIndex( [ 'action_iploc', ] )
        ->addIndex( [ 'erpt', ] )
        ->addIndex( [ 'mobapp', ] )
        ->addIndex( [ 'created', ] )
        ->addIndex( [ 'modified', ] )
        ->create();
    }

    public function down()
    {
        $this->table('useractions')->drop()->save();
    }
}
