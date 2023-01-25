<?php

namespace Atcmobapp\Mobapps\Model\Table;

use Cake\Database\Schema\TableSchema;
use Cake\Event\Event;
use Cake\I18n\I18n;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;
use Cake\Validation\Validator;
use Atcmobapp\Core\Atcmobapp;
use Atcmobapp\Core\Model\Table\AtcmobappTable;
use Atcmobapp\Mobapps\Model\Entity\Urole;

class UrolesTable extends Table
{
    public function initialize(array $config)
    {

    }

    protected function _initializeSchema(TableSchema $table)
    {

    }

    public function findFilterUroles(Query $query, array $options = [])
    {

    }

    public function findFilterPublishedUroles(Query $query, array $options = [])
    {

    }

    public function validationDefault(Validator $validator)
    {
        return $validator;
    }

    public function buildRules(RulesChecker $rules)
    {

    }

    public function saveUrole(Urole $urole)
    {
        $result = $this->save($urole);
        Atcmobapp::dispatchEvent('Model.Uroles.afterSaveUrole', $this, $event->data);
        return $result;
    }

    public function formatUrole($data)
    {

    }

    public function findView(Query $query, array $options = [])
    {

    }

    public function findViewById(Query $query, array $options = [])
    {

    }

    public function beforeSave(Event $event)
    {

    }

    public function afterSave(Event $event)
    {

    }
}
