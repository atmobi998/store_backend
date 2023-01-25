<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class MobtktdetsInitialMigration extends AbstractMigration
{
    public function up()
    {

    $this->table('mobtktdets',['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false, 'identity' => true ])
        ->addColumn('sess_id', 'biginteger', [ 'default' => 0, 'limit' => 20, 'null' => false ])
        ->addColumn('tkt_id', 'biginteger', [ 'default' => 0, 'limit' => 20, 'null' => false ])
        ->addColumn('prod_id', 'biginteger', [ 'default' => 0, 'limit' => 20, 'null' => false ])
        ->addColumn('prd_name', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('prdopt_id', 'biginteger', [ 'default' => 0, 'limit' => 20, 'null' => true ])
        ->addColumn('prdopt_name', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('color', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
        ->addColumn('quantity', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('weight', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('price', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('tax', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('subtotal', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('note', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => '', 'null' => true, ])
        ->addColumn('stkupd', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'tkt_id', ] )
        ->addIndex( [ 'sess_id', ] )
        ->addIndex( [ 'prod_id', ] )
        ->addIndex( [ 'prdopt_id', ] )
        ->addIndex( [ 'prd_name', ] )
        ->addIndex( [ 'prdopt_name', ] )
        ->addIndex( [ 'stkupd', ] )
        ->addIndex( [ 'created', ] )
        ->addIndex( [ 'modified', ] )
        ->create();
    }

    public function down()
    {
        $this->table('mobtktdets')->drop()->save();
    }
}
