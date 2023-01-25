<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class MobpossecsInitialMigration extends AbstractMigration
{
    public function up()
    {

    $this->table('mobpossecs',['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false, 'identity' => true ])
        ->addColumn('pos_id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false ])
        ->addColumn('startcash', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('timestart', 'datetime', [ 'default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => true, ])
        ->addColumn('endcash', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('endtime', 'datetime', [ 'default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => true, ])
        ->addColumn('curcash', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('curtime', 'datetime', [ 'default' => 'CURRENT_TIMESTAMP', 'limit' => null, 'null' => true, ])
        ->addColumn('mgr_note', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => null, 'null' => true, ])
        ->addColumn('cashier_note', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => null, 'null' => true, ])
        ->addColumn('totcurtkt', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('totendtkt', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('is_working', 'integer', [ 'default' => 1, 'null' => true, ])
        ->addColumn('is_break', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('is_close', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('stkupd', 'integer', [ 'default' => 0, 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'pos_id', ] )
        ->addIndex( [ 'timestart', ] )
        ->addIndex( [ 'endtime', ] )
        ->addIndex( [ 'curtime', ] )
        ->addIndex( [ 'is_working', ] )
        ->addIndex( [ 'is_break', ] )
        ->addIndex( [ 'is_close', ] )
        ->addIndex( [ 'stkupd', ] )
        ->addIndex( [ 'created', ] )
        ->addIndex( [ 'modified', ] )
        ->create();
    }

    public function down()
    {
        $this->table('mobpossecs')->drop()->save();
    }
}
