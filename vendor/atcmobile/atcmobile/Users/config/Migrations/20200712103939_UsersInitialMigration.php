<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class UsersInitialMigration extends AbstractMigration
{
    public function up()
    {

        $this->table('roles')
            ->addColumn('title', 'string', [ 'default' => null, 'limit' => 100, 'null' => false, ])
            ->addColumn('alias', 'string', [ 'default' => null, 'limit' => 100, 'null' => true, ])
            ->addTimestamps('created', 'modified')
            ->addColumn('created_by', 'integer', [ 'default' => null, 'limit' => 20, 'null' => false, ])
            ->addColumn('modified_by', 'integer', [ 'default' => null, 'limit' => 20, 'null' => true, ])
            ->addIndex( [ 'alias', ], ['unique' => true] )
            ->create();

        $this->table('users')
		->addColumn('role_id', 'integer', [ 'default' => null, 'limit' => 11, 'null' => false, ])
		->addColumn('username', 'string', [ 'default' => null, 'limit' => 60, 'null' => false, ])
		->addColumn('password', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
		->addColumn('verify_password', 'string', [ 'default' => null, 'limit' => 255, 'null' => true, ])
		->addColumn('name', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
		->addColumn('firstname', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
		->addColumn('lastname', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
		->addColumn('email', 'string', [ 'default' => '', 'limit' => 100, 'null' => false, ])
		->addColumn('website', 'string', [ 'default' => '', 'limit' => 100, 'null' => true, ])
		->addColumn('address', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
		->addColumn('address2', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
		->addColumn('phone', 'string', [ 'default' => '', 'limit' => 30, 'null' => true, ])
		->addColumn('phone_code', 'string', [ 'default' => '', 'limit' => 30, 'null' => true, ])
		->addColumn('pn_verify', 'integer', [ 'default' => 0, 'limit' => 1, 'null' => true, ])
		->addColumn('code_sent', 'datetime', [ 'default' => null, 'limit' => null, 'null' => true, ])
		->addColumn('sent_value', 'string', [ 'default' => '', 'limit' => 30, 'null' => true, ])
		->addColumn('fax', 'string', [ 'default' => '', 'limit' => 30, 'null' => true, ])
		->addColumn('has_logo', 'integer', [ 'default' => 0, 'limit' => 1, 'null' => true, ])
		->addColumn('logo_text', 'string', [ 'default' => 'Logo Text', 'limit' => 100, 'null' => true, ])
		->addColumn('logo_img', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
		->addColumn('logo_w', 'integer', [ 'default' => 0, 'limit' => 6, 'null' => true, ])
		->addColumn('logo_h', 'integer', [ 'default' => 0, 'limit' => 6, 'null' => true, ])
		->addColumn('self_img', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
		->addColumn('self_w', 'integer', [ 'default' => 0, 'limit' => 6, 'null' => true, ])
		->addColumn('self_h', 'integer', [ 'default' => 0, 'limit' => 6, 'null' => true, ])
		->addColumn('img_host', 'string', [ 'default' => 'https://metroeconomics.com', 'limit' => 255, 'null' => true, ])
		->addColumn('currency', 'string', [ 'default' => 'VND', 'limit' => 30, 'null' => true, ])
		->addColumn('zipcode', 'string', [ 'default' => '', 'limit' => 30, 'null' => true, ])
		->addColumn('country_id', 'string', [ 'default' => 'VN', 'limit' => 15, 'null' => true, ])
		->addColumn('country_name', 'string', [ 'default' => 'Vietnam', 'limit' => 100, 'null' => true, ])
		->addColumn('state_id', 'string', [ 'default' => 'HCM', 'limit' => 15, 'null' => true, ])
		->addColumn('state_name', 'string', [ 'default' => 'Ho Chi Minh', 'limit' => 100, 'null' => true, ])
		->addColumn('city_name', 'string', [ 'default' => 'Ho Chi Minh City', 'limit' => 100, 'null' => true, ])
		->addColumn('local_name', 'string', [ 'default' => '', 'limit' => 100, 'null' => true, ])
		->addColumn('group_id', 'integer', [ 'default' => null, 'null' => true, ])
		->addColumn('profile_path', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
		->addColumn('activation_key', 'string', [ 'default' => '', 'limit' => 60, 'null' => true, ])
		->addColumn('status', 'boolean', [ 'default' => false, 'null' => false, ])
		->addColumn('banned', 'integer', [ 'default' => 0, 'limit' => 1, 'null' => true, ])
		->addColumn('note', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => '', 'null' => true, ])
		->addColumn('timezone', 'string', [ 'default' => 'UTC', 'limit' => 40, 'null' => false, ])
		->addColumn('twit_id', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
		->addColumn('twit_creds', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
		->addColumn('fb_id', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
		->addColumn('fb_creds', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
		->addColumn('aws_id', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
		->addColumn('aws_creds', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
		->addColumn('google_id', 'string', [ 'default' => '', 'limit' => 50, 'null' => true, ])
		->addColumn('google_creds', 'string', [ 'default' => '', 'limit' => 255, 'null' => true, ])
		->addColumn('notifications', 'integer', [ 'default' => 1, 'limit' => 1, 'null' => true, ])
		->addColumn('balance', 'double', [ 'default' => 0, 'null' => false, ])
		->addColumn('data', 'text', [ 'limit' => MysqlAdapter::TEXT_MEDIUM, 'default' => '', 'null' => true, ])
		->addTimestamps('created', 'modified')
		->addColumn('created_by', 'integer', [ 'default' => 1, 'limit' => 20, 'null' => true, ])
		->addColumn('modified_by', 'integer', [ 'default' => 1, 'limit' => 20, 'null' => true, ])
		->addForeignKey('role_id', 'roles', ['id'], [ 'constraint' => 'fk_users2roles', 'delete' => 'RESTRICT', ])
		->addIndex( [ 'username', ], ['unique' => true] )
		->addIndex( [ 'email', ] )
		->addIndex( [ 'country_id', ] )
		->addIndex( [ 'state_id', ] )
		->addIndex( [ 'group_id', ] )
		->addIndex( [ 'banned', ] )
		->addIndex( [ 'status', ] )
		->create();

        $this->table('roles_users')
            ->addColumn('user_id', 'integer', [ 'default' => null, 'limit' => 11, 'null' => false, ])
            ->addColumn('role_id', 'integer', [ 'default' => null, 'limit' => 11, 'null' => false, ])
            ->addColumn('granted_by', 'integer', [ 'default' => null, 'limit' => 11, 'null' => true, ])
            ->addTimestamps('created', 'modified')
            ->addForeignKey('user_id', 'users', ['id'], [ 'constraint' => 'fk_roles_users2users', 'delete' => 'RESTRICT', ])
            ->addForeignKey('role_id', 'roles', ['id'], [ 'constraint' => 'fk_roles_users2roles', 'delete' => 'RESTRICT', ])
            ->addIndex( [ 'user_id', ] )
            ->create();
	    
    }

    public function down()
    {
        $this->table('roles')->drop()->save();
        $this->table('users')->drop()->save();
        $this->table('roles_users')->drop()->save();
    }
}
