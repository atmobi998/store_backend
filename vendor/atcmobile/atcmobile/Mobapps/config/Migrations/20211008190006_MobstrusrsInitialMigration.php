<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class MobstrusrsInitialMigration extends AbstractMigration
{
    public function up()
    {

    $this->table('mobstrusrs',['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false, 'identity' => true ])
        ->addColumn('store_id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false ])
        ->addColumn('store_code', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('usr_name', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('usr_code', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('usr_passcode', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('passcode_bk', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('is_pos', 'integer', [ 'default' => 1, 'null' => true, ])
        ->addColumn('is_inv', 'integer', [ 'default' => 1, 'null' => true, ])
        ->addColumn('is_kitchen', 'integer', [ 'default' => 1, 'null' => true, ])
        ->addColumn('is_frontst', 'integer', [ 'default' => 1, 'null' => true, ])
        ->addColumn('active', 'integer', [ 'default' => 1, 'null' => true, ])
        ->addColumn('dev_ip', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
        ->addColumn('dev_token', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => '', 'null' => true, ])
        ->addColumn('status', 'string', [ 'default' => '', 'limit' => 100, 'null' => true, ])  // working lockforbreak timeoutlock
        ->addColumn('staff_img', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('img_w', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('img_h', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('phone', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
        ->addColumn('name', 'string', [ 'default' => '', 'limit' => 100, 'null' => true, ])
        ->addColumn('addr', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('addr2', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('city', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('zip', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('state', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('country', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('devinfo', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'store_id', ] )
        ->addIndex( [ 'store_code', ] )
        ->addIndex( [ 'usr_name', ] )
        ->addIndex( [ 'usr_code', ] )
        ->addIndex( [ 'active', ] )
        ->addIndex( [ 'dev_ip', ] )
        ->addIndex( [ 'phone', ] )
        ->addIndex( [ 'is_pos', ] )
        ->addIndex( [ 'is_inv', ] )
        ->addIndex( [ 'is_kitchen', ] )
        ->addIndex( [ 'is_frontst', ] )
        ->addIndex( [ 'status', ] )
        ->create();
    }

    public function down()
    {
        $this->table('mobstrusrs')->drop()->save();
    }
}
