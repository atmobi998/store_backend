<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class MobclitransInitialMigration extends AbstractMigration
{
    public function up()
    {

    $this->table('mobclitrans',['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false, 'identity' => true ])
        ->addColumn('user_id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false ])
        ->addColumn('cli_id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false ])
        ->addColumn('amount', 'double', [ 'default' => 0, 'null' => false, ])
        ->addColumn('upfee', 'double', [ 'default' => 0, 'null' => false, ])
        ->addColumn('total', 'double', [ 'default' => 0, 'null' => false, ])
        ->addColumn('balanced', 'integer', [ 'default' => 1, 'null' => false, ])
        ->addColumn('currency', 'string', [ 'default' => 'VND', 'limit' => 30, 'null' => true, ])
        ->addColumn('comment', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => '', 'null' => true, ])
        ->addColumn('card_owner', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('card_number', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
        ->addColumn('card_code', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
        ->addColumn('card_year', 'string', [ 'default' => '', 'limit' => 10, 'null' => true, ])
        ->addColumn('card_month', 'string', [ 'default' => '', 'limit' => 10, 'null' => true, ])
        ->addColumn('authorization', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('transaction', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('status', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ]) 
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'cli_id', ] )
        ->addIndex( [ 'user_id', ] )
        ->addIndex( [ 'balanced', ] )
        ->addIndex( [ 'status', ] )
        ->addIndex( [ 'card_owner', ] )
        ->addIndex( [ 'card_number', ] )
        ->addIndex( [ 'transaction', ] )
        ->create();
    }

    public function down()
    {
        $this->table('mobclitrans')->drop()->save();
    }
}
