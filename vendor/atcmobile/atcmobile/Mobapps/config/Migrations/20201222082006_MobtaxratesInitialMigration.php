<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class MobtaxratesInitialMigration extends AbstractMigration
{
    public function up()
    {

    $this->table('mobtaxrates',['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false, 'identity' => true ])
        ->addColumn('store_id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false ])
        ->addColumn('name', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
        ->addColumn('taxrate', 'float', [ 'null' => true, 'default' => 7.5])
        ->addColumn('sort', 'integer', [ 'default' => 1, 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'store_id', ] )
        ->addIndex( [ 'name', ] )
        ->addIndex( [ 'taxrate', ] )
        ->addIndex( [ 'sort', ] )
        ->create();
    }

    public function down()
    {
        $this->table('mobtaxrates')->drop()->save();
    }
}
