<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class MobprdimgsInitialMigration extends AbstractMigration
{
    public function up()
    {

    $this->table('mobprdimgs',['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false, 'identity' => true ])
        ->addColumn('prod_id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false ])
        ->addColumn('img_title', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('img_host', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('img_path', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('img_w', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('img_h', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('sort', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'prod_id', ] )
        ->addIndex( [ 'img_host', ] )
        ->addIndex( [ 'img_path', ] )
        ->create();
    }

    public function down()
    {
        $this->table('mobprdimgs')->drop()->save();
    }
}
