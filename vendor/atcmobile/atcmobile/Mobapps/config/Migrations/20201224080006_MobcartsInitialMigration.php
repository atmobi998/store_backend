<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class MobcartsInitialMigration extends AbstractMigration
{
    public function up()
    {

    $this->table('mobcarts',['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false, 'identity' => true ])
        ->addColumn('session_id', 'string', [ 'default' => null, 'limit' => 255, 'null' => false, ])
        ->addColumn('user_id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => true ])
        ->addColumn('email', 'string', [ 'default' => null, 'limit' => 100, 'null' => true, ])
        ->addColumn('phone', 'string', [ 'default' => null, 'limit' => 50, 'null' => true, ])
        ->addColumn('devinfo', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => null, 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'session_id', ] )
        ->addIndex( [ 'user_id', ] )
        ->addIndex( [ 'email', ] )
        ->addIndex( [ 'phone', ] )
        ->create();
    }

    public function down()
    {
        $this->table('mobcarts')->drop()->save();
    }
}
