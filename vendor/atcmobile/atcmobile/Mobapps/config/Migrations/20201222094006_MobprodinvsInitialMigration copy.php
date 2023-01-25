<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class MobprodinvsInitialMigration extends AbstractMigration
{
    public function up()
    {

    $this->table('mobprodinvs',['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false, 'identity' => true ])
        ->addColumn('store_id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false ])
        ->addColumn('prod_id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false ])
        ->addColumn('prod_code', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('quantity', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('inv', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('kitchen', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('front', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('pos', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('stkin', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('stkout', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('stocked', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('inv_id', 'biginteger', [ 'default' => 0, 'limit' => 20, 'null' => true ])
        ->addColumn('kitchen_id', 'biginteger', [ 'default' => 0, 'limit' => 20, 'null' => true ])
        ->addColumn('front_id', 'biginteger', [ 'default' => 0, 'limit' => 20, 'null' => true ])
        ->addColumn('pos_id', 'biginteger', [ 'default' => 0, 'limit' => 20, 'null' => true ])
        ->addColumn('note', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => null, 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'store_id', ] )
        ->addIndex( [ 'prod_id', ] )
        ->addIndex( [ 'prod_code', ] )
        ->addIndex( [ 'inv', ] )
        ->addIndex( [ 'kitchen', ] )
        ->addIndex( [ 'front', ] )
        ->addIndex( [ 'pos', ] )
        ->addIndex( [ 'kitchen_id', ] )
        ->addIndex( [ 'inv_id', ] )
        ->addIndex( [ 'front_id', ] )
        ->addIndex( [ 'pos_id', ] )
        ->addIndex( [ 'stkin', ] )
        ->addIndex( [ 'stkout', ] )
        ->addIndex( [ 'stocked', ] )
        ->addIndex( [ 'created', ] )
        ->addIndex( [ 'modified', ] )
        ->create();
    }

    public function down()
    {
        $this->table('mobprodinvs')->drop()->save();
    }
}
