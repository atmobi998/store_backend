<?php

use Cake\Auth\DefaultPasswordHasher;
use Cake\Log\LogTrait;
use Cake\ORM\TableRegistry;
use Phinx\Seed\AbstractSeed;

class UsersSeed extends AbstractSeed
{

    use LogTrait;
    
    public $record = [ 'id' => 1, 'role_id' => 3, 'username' => 'seed', 'name' => 'Seed User', 'email' => 'seed@example.com', 'status' => false, 'timezone' => 'UTC', 'created_by' => 1, ];

    public $records = array();

    public function getDependencies()
    {
        return [ 'RolesSeed', ];
    }

    public function run()
    {
    
        $Users = TableRegistry::get('Atcmobapp/Users.Users');
        $Roles = TableRegistry::get('Atcmobapp/Users.Roles');
        $Roles->addBehavior('Atcmobapp/Core.Aliasable');
        $this->getAdapter()->commitTransaction();
        $entity = $Users->newEntity($this->record);
        $result = $Users->save($entity);
        $this->getAdapter()->beginTransaction();
	
        $hasher = new DefaultPasswordHasher();
        while (list($uk,$uv) = each($this->records)) {
            $this->getAdapter()->commitTransaction();
            $uv['password'] = $uv['verify_password'];
            $uv['activation_key'] = md5(uniqid());
            $entity = $Users->newEntity($uv);
            $result = $Users->save($entity);
            $this->getAdapter()->beginTransaction();
        }
	
    }
}

 