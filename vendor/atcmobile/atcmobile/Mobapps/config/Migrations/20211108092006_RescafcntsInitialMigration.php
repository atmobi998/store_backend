<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class RescafcntsInitialMigration extends AbstractMigration
{
    public function up()
    {

    $this->table('rescafcnts',['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false, 'identity' => true ])
        ->addColumn('store_id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false ])
        ->addColumn('store_name', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('sess_id', 'biginteger', [ 'default' => 0, 'limit' => 20, 'null' => true ])
        ->addColumn('pos_id', 'biginteger', [ 'default' => 0, 'limit' => 20, 'null' => true ])
        ->addColumn('pos_name', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('pos_username', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('order_count', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('orders', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => '', 'null' => true, ])
        ->addColumn('subtotal', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('tax', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('total', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('ip_address', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
        ->addColumn('remote_host', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('comment', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => '', 'null' => true, ])
        ->addColumn('note', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => '', 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'store_id', ] )
        ->addIndex( [ 'store_name', ] )
        ->addIndex( [ 'pos_id', ] )
        ->addIndex( [ 'pos_name', ] )
        ->addIndex( [ 'pos_username', ] )
        ->addIndex( [ 'sess_id', ] )
        ->addIndex( [ 'ip_address', ] )
        ->addIndex( [ 'remote_host', ] )
        ->addIndex( [ 'created', ] )
        ->addIndex( [ 'modified', ] )
        ->create();
    }

    public function down()
    {
        $this->table('rescafcnts')->drop()->save();
    }
}
