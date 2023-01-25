<?php

namespace Atcmobapp\Contacts\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Atcmobapp\Core\Model\Table\AtcmobappTable;

/**
 * Contact
 *
 * @category Model
 * @package  Atcmobapp.Contacts.Model
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class ContactsTable extends AtcmobappTable
{

    public function validationDefault(Validator $validator)
    {
        $validator
            ->notBlank('title', __d('atcmobile', 'Title cannot be empty.'))
            ->notBlank('alias', __d('atcmobile', 'Alias cannot be empty.'))
            ->email('email', __d('atcmobile', 'Not a valid email address.'));

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
        $this->setDisplayField('title');
        $this->setEntityClass('Atcmobapp/Contacts.Contact');
        $this->hasMany('Messages', [
            'className' => 'Atcmobapp/Contacts.Messages',
            'foreignKey' => 'contact_id',
            'dependent' => false,
            'limit' => '3',
        ]);
        $this->addBehavior('Atcmobapp/Core.Cached', [
            'groups' => ['contacts']
        ]);
        $this->addBehavior('Atcmobapp/Core.Trackable');
        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');
    }

    /**
     * Display fields for this model
     *
     * @var array
     */
    protected $_displayFields = [
        'title',
        'alias',
        'email',
    ];
}
