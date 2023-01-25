<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class MobclisInitialMigration extends AbstractMigration
{
    public function up()
    {

    $this->table('mobclis',['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false, 'identity' => true ])
        ->addColumn('user_id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false ])
        ->addColumn('cli_code', 'string', [ 'default' => '', 'limit' => 100, 'null' => true, ])
        ->addColumn('cli_name', 'string', [ 'default' => '', 'limit' => 100, 'null' => true, ])
        ->addColumn('cli_email', 'string', [ 'default' => '', 'limit' => 100, 'null' => true, ])
        ->addColumn('cli_phone', 'string', [ 'default' => '', 'limit' => 30, 'null' => true, ])
        ->addColumn('cli_fax', 'string', [ 'default' => '', 'limit' => 30, 'null' => true, ])
        ->addColumn('cli_addr', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('cli_addr2', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('cli_city', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('cli_zip', 'string', [ 'default' => '', 'limit' => 100, 'null' => true, ])
        ->addColumn('cli_state', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('cli_country', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('home_lat', 'double', [ 'null' => 0, 'default' => 0])
        ->addColumn('home_lng', 'double', [ 'null' => 0, 'default' => 0])
        ->addColumn('cli_lat', 'double', [ 'null' => 0, 'default' => 0])
        ->addColumn('cli_lng', 'double', [ 'null' => 0, 'default' => 0])
        ->addColumn('cli_status', 'string', [ 'default' => 'Cab call', 'limit' => 50, 'null' => true, ])  
        ->addColumn('cli_img', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('img_w', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('img_h', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('up_img', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('up_img_w', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('up_img_h', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('nid_info', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => '', 'null' => true, ])
        ->addColumn('nid_name', 'string', [ 'default' => '', 'limit' => 100, 'null' => true, ])
        ->addColumn('nid_nbr', 'string', [ 'default' => '', 'limit' => 100, 'null' => true, ])
        ->addColumn('nid_bplace', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('nid_bdate', 'timestamp', [ 'default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => true, ])
        ->addColumn('nid_date', 'timestamp', [ 'default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => true, ])
        ->addColumn('nid_img', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('nid_img_w', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('nid_img_h', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('cli_verify', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('verify_date', 'timestamp', [ 'default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => true, ])
        ->addColumn('verify_note', 'string', [ 'default' => '', 'limit' => 512, 'null' => true, ])
        ->addColumn('bcntry_code', 'string', [ 'default' => 'VN', 'limit' => 30, 'null' => true, ])
        ->addColumn('scntry_code', 'string', [ 'default' => 'VN', 'limit' => 30, 'null' => true, ])
        ->addColumn('currency', 'string', [ 'default' => 'VND', 'limit' => 30, 'null' => true, ])
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
        ->addColumn('payment_method', 'string', [ 'default' => 'VISA', 'limit' => 255, 'null' => true, ])
        ->addColumn('card_owner', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('card_number', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
        ->addColumn('card_code', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
        ->addColumn('card_year', 'string', [ 'default' => '', 'limit' => 10, 'null' => true, ])
        ->addColumn('card_month', 'string', [ 'default' => '', 'limit' => 10, 'null' => true, ])
        ->addColumn('authorization', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('transaction', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('balance', 'double', [ 'default' => 0, 'null' => false, ])
        ->addColumn('last_acc_ip', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
        ->addColumn('last_acc_token', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => '', 'null' => true, ])
        ->addColumn('devinfo', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'user_id', ] )
        ->addIndex( [ 'cli_lat', ] )
        ->addIndex( [ 'cli_lng', ] )
        ->addIndex( [ 'cli_status', ] )
        ->addIndex( [ 'cli_email', ] )
        ->addIndex( [ 'cli_phone', ] )
        ->addIndex( [ 'cli_verify', ] )
        ->addIndex( [ 'bcntry_code', ] )
        ->addIndex( [ 'scntry_code', ] )
        ->create();
    }

    public function down()
    {
        $this->table('mobclis')->drop()->save();
    }
}