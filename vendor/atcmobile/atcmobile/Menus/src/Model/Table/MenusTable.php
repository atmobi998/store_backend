<?php

namespace Atcmobapp\Menus\Model\Table;

use Cake\Database\Schema\TableSchema;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Atcmobapp\Core\Model\Table\AtcmobappTable;

/**
 * Menu
 *
 * @property LinksTable Links
 * @category Model
 * @package  Atcmobapp.Menus.Model
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class MenusTable extends AtcmobappTable
{

    public function validationDefault(Validator $validator)
    {
        $validator
            ->notBlank('title', __d('atcmobile', 'Title cannot be empty.'))
            ->notBlank('alias', __d('atcmobile', 'Alias cannot be empty.'));

        return $validator;
    }

    public function buildRules(RulesChecker $rules)
    {
        $rules
            ->add($rules->isUnique(
                ['alias'],
                __d('atcmobile', 'That alias is already taken')
            ));

        return $rules;
    }

    public function initialize(array $config)
    {
        $this->addBehavior('Atcmobapp/Core.Cached', [
            'groups' => [
                'menus',
            ],
        ]);
        $this->addBehavior('Atcmobapp/Core.Publishable');
        $this->addBehavior('Atcmobapp/Core.Trackable');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');

        $this->hasMany('Links', [
            'className' => 'Atcmobapp/Menus.Links',
            'order' => [
                'lft' => 'ASC'
            ],
        ]);
    }

    protected function _initializeSchema(TableSchema $table)
    {
        $table->setColumnType('params', 'params');

        return parent::_initializeSchema($table);
    }

    /**
     * beforeDelete callback
     */
    public function beforeDelete(Event $event, Entity $entity, $options)
    {
        // Set tree scope for Links association
        $settings = [
            'scope' => [$this->Links->getAlias() . '.menu_id' => $entity->id],
        ];
        if ($this->Links->hasBehavior('Tree')) {
            $this->Links->behaviors()->get('Tree')->config($settings);
        } else {
            $this->Links->addBehavior('Tree', $settings);
        }
    }
}
