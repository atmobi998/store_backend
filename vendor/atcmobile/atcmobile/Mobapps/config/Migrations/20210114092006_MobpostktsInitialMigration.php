<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class MobpostktsInitialMigration extends AbstractMigration
{
    public function up()
    {

    $this->table('mobpostkts',['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false, 'identity' => true ])
        ->addColumn('pos_id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false ])
        ->addColumn('sess_id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false ])
        ->addColumn('first_name', 'string', [ 'default' => '', 'limit' => 100, 'null' => true, ])
        ->addColumn('last_name', 'string', [ 'default' => '', 'limit' => 100, 'null' => true, ])
        ->addColumn('email', 'string', [ 'default' => '', 'limit' => 100, 'null' => true, ])
        ->addColumn('phone', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
        ->addColumn('billing_address', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('billing_address2', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('billing_city', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('billing_zip', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('billing_state', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('billing_country', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('shipping_address', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('shipping_address2', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('shipping_city', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('shipping_zip', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('shipping_state', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('shipping_country', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('weight', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('item_count', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('subtotal', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('tax', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('shipping', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('total', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('cash', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('cashchg', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('shipping_method', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('payment_method', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('card_owner', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('card_number', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
        ->addColumn('card_code', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
        ->addColumn('card_year', 'string', [ 'default' => '', 'limit' => 10, 'null' => true, ])
        ->addColumn('card_month', 'string', [ 'default' => '', 'limit' => 10, 'null' => true, ])
        ->addColumn('authorization', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('transaction', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('status', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('ip_address', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
        ->addColumn('remote_host', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('note', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => '', 'null' => true, ])
        ->addColumn('tktpdf', 'blob', [ 'limit' => MysqlAdapter::BLOB_MEDIUM, 'default' => '', 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'pos_id', ] )
        ->addIndex( [ 'sess_id', ] )
        ->addIndex( [ 'first_name', ] )
        ->addIndex( [ 'last_name', ] )
        ->addIndex( [ 'email', ] )
        ->addIndex( [ 'phone', ] )
        ->addIndex( [ 'ip_address', ] )
        ->addIndex( [ 'status', ] )
        ->addIndex( [ 'total', ] )
        ->addIndex( [ 'subtotal', ] )
        ->addIndex( [ 'created', ] )
        ->addIndex( [ 'modified', ] )
        ->create();
    }

    public function down()
    {
        $this->table('mobpostkts')->drop()->save();
    }
}
