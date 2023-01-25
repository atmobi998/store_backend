<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class MobcartitmsInitialMigration extends AbstractMigration
{
    public function up()
    {

    $this->table('mobcartitms',['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false, 'identity' => true ])
        ->addColumn('cart_id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false ])
        ->addColumn('prod_id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false ])
        ->addColumn('prdopt_id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false ])
        ->addColumn('note', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('qty', 'integer', [ 'default' => 1, 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'cart_id', ] )
        ->addIndex( [ 'prod_id', ] )
        ->addIndex( [ 'prdopt_id', ] )
        ->create();
    }

    public function down()
    {
        $this->table('mobcartitms')->drop()->save();
    }
}
