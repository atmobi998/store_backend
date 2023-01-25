<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class MobsupplsInitialMigration extends AbstractMigration
{
    public function up()
    {

    $this->table('mobsuppls',['id' => false, 'primary_key' => ['id']])
        ->addColumn('id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false, 'identity' => true ])
        ->addColumn('store_id', 'biginteger', [ 'default' => null, 'limit' => 20, 'null' => false ])
        ->addColumn('searchkey', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('taxid', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('name', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('maxdebt', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('address', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('address2', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('zip', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('city', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('state', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('region', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('country', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('firstname', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('lastname', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('email', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('phone', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('phone2', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('fax', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('notes', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => null, 'null' => true, ])
        ->addColumn('curdate', 'datetime', [ 'default' => null, 'limit' => null, 'null' => true, ])
        ->addColumn('curdebt', 'float', [ 'null' => true, 'default' => 0])
        ->addColumn('vatid', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
        ->addColumn('lft', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('rght', 'integer', [ 'default' => null, 'null' => true, ])
        ->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 11, 'null' => true, ])
        ->addTimestamps('created', 'modified')
        ->addIndex( [ 'name', ] )
        ->addIndex( [ 'store_id', ] )
        ->addIndex( [ 'searchkey', ] )
        ->addIndex( [ 'taxid', ] )
        ->addIndex( [ 'vatid', ] )
        ->create();
    }

    public function down()
    {
        $this->table('mobsuppls')->drop()->save();
    }
}
