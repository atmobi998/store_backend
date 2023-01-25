<?php

namespace Atcmobapp\Mobapps\Model\Table;

use Cake\Database\Schema\TableSchema;
use Cake\Event\Event;
use Cake\I18n\I18n;
use Cake\ORM\Table;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Validation\Validator;
use Atcmobapp\Core\Atcmobapp;
use Atcmobapp\Core\Model\Table\AtcmobappTable;
use Atcmobapp\Mobapps\Model\Entity\Mobstoretran;

class MobstoretransTable extends Table
{
    public function initialize(array $config)
    {
        parent::initialize($config);
        $this->addBehavior('Timestamp');
    }


}
