<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class MobprdoptsInitialMigration extends AbstractMigration
{
    public function up()
    {

    $this->table('mobprdopts',['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false, 'identity' => true ])
        ->addColumn('prod_id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false ])
        ->addColumn('optname', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('optvalue', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('description', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => null, 'null' => true, ])
        ->addColumn('image', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('color', 'string', [ 'default' => null, 'limit' => 50, 'null' => true, ])
        ->addColumn('price', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('weight', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('size_w', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('size_h', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('size_d', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('views', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('sort', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('active', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'prod_id', ] )
        ->addIndex( [ 'optname', ] )
        ->addIndex( [ 'optvalue', ] )
        ->addIndex( [ 'price', ] )
        ->addIndex( [ 'color', ] )
        ->addIndex( [ 'sort', ] )
        ->addIndex( [ 'active', ] )
        ->create();
    }

    public function down()
    {
        $this->table('mobprdopts')->drop()->save();
    }
}
