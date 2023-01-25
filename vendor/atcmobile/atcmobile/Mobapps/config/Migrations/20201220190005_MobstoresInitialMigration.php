<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class MobstoresInitialMigration extends AbstractMigration
{
    public function up()
    {

    $this->table('mobstores',['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false, 'identity' => true ])
        ->addColumn('user_id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false ])
        ->addColumn('store_code', 'string', [ 'default' => '', 'limit' => 100, 'null' => true, ])
        ->addColumn('store_name', 'string', [ 'default' => '', 'limit' => 100, 'null' => true, ])
        ->addColumn('store_email', 'string', [ 'default' => '', 'limit' => 100, 'null' => true, ])
        ->addColumn('store_phone', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
        ->addColumn('store_fax', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
        ->addColumn('store_addr', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('store_addr2', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('store_city', 'string', [ 'default' => 'Ho Chi Minh', 'limit' => 255, 'null' => true, ])
        ->addColumn('store_zip', 'string', [ 'default' => '700000', 'limit' => 255, 'null' => true, ])
        ->addColumn('store_state', 'string', [ 'default' => 'Ho Chi Minh', 'limit' => 255, 'null' => true, ])
        ->addColumn('store_country', 'string', [ 'default' => 'Vietnam', 'limit' => 255, 'null' => true, ])
        ->addColumn('currency', 'string', [ 'default' => 'VND', 'limit' => 30, 'null' => true, ])
        ->addColumn('store_lat', 'double', [ 'null' => 0, 'default' => 0])
        ->addColumn('store_lng', 'double', [ 'null' => 0, 'default' => 0])
        ->addColumn('rescaf', 'integer', [ 'default' => 1, 'null' => true, ])
        ->addColumn('rescaf_tabs', 'integer', [ 'default' => 20, 'null' => true, ])
        ->addColumn('rescaf_take', 'integer', [ 'default' => 1, 'null' => true, ])
        ->addColumn('cvsmart', 'integer', [ 'default' => 1, 'null' => true, ])
        ->addColumn('pharmacy', 'integer', [ 'default' => 1, 'null' => true, ])
        ->addColumn('logo_img', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('logo_w', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('logo_h', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('up_logo_img', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('up_logo_w', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('up_logo_h', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('bcntry_code', 'string', [ 'default' => 'VN', 'limit' => 30, 'null' => true, ])
        ->addColumn('scntry_code', 'string', [ 'default' => 'VN', 'limit' => 30, 'null' => true, ])
        ->addColumn('billing_phone', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
        ->addColumn('billing_name', 'string', [ 'default' => '', 'limit' => 100, 'null' => true, ])
        ->addColumn('billing_addr', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('billing_addr2', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('billing_city', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('billing_zip', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('billing_state', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('billing_country', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('shipping_phone', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
        ->addColumn('shipping_name', 'string', [ 'default' => '', 'limit' => 100, 'null' => true, ])
        ->addColumn('shipping_addr', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('shipping_addr2', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('shipping_city', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('shipping_zip', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('shipping_state', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('shipping_country', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('payment_method', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('card_owner', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('card_number', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
        ->addColumn('card_code', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
        ->addColumn('card_year', 'string', [ 'default' => '', 'limit' => 10, 'null' => true, ])
        ->addColumn('card_month', 'string', [ 'default' => '', 'limit' => 10, 'null' => true, ])
        ->addColumn('authorization', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('transaction', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('balance', 'double', [ 'default' => 0, 'null' => false, ])
        ->addColumn('acc_ip', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
        ->addColumn('acc_token', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => '', 'null' => true, ])
        ->addColumn('devinfo', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => '', 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'user_id', ] )
        ->addIndex( [ 'store_name', ] )
        ->addIndex( [ 'store_phone', ] )
        ->addIndex( [ 'store_email', ] )
        ->addIndex( [ 'store_lat', ] )
        ->addIndex( [ 'store_lng', ] )
        ->addIndex( [ 'bcntry_code', ] )
        ->addIndex( [ 'scntry_code', ] )
        ->create();
    }

    public function down()
    {
        $this->table('mobstores')->drop()->save();
    }
}
