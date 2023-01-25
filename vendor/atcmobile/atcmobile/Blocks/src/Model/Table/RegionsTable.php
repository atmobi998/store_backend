<?php

namespace Atcmobapp\Blocks\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Atcmobapp\Core\Model\Table\AtcmobappTable;

/**
 * Region
 *
 * @category Blocks.Model
 * @package  Atcmobapp.Blocks.Model
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class RegionsTable extends AtcmobappTable
{

    /**
     * Display fields for this model
     *
     * @var array
     */
    protected $_displayFields = [
        'id',
        'title',
        'alias',
    ];

    /**
     * Find methods
     */
    public $findMethods = [
        'active' => true,
    ];

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
        $this->setEntityClass('Atcmobapp/Blocks.Region');
        $this->addAssociations([
            'hasMany' => [
                'Blocks' => [
                    'className' => 'Atcmobapp/Blocks.Blocks',
                    'foreignKey' => 'region_id',
                    'dependent' => false,
                    'limit' => 3,
                ],
            ],
        ]);

        $this->addBehavior('Search.Search');
//        $this->addBehavior('Atcmobapp.Cached', [
//            'groups' => [
//                'blocks',
//            ],
//        ]);

        $this->addBehavior('Timestamp');
        $this->addBehavior('Atcmobapp/Core.Trackable');
        $this->addBehavior('Search.Search');

        $this->searchManager()
            ->add('title', 'Search.Like', [
                'field' => $this->aliasField('title'),
                'before' => true,
                'after' => true,
            ]);
    }

    /**
     * Find Regions currently in use
     */
    public function findActive(Query $query)
    {
        return $query->where([
            'block_count >' => 0,
        ]);
    }
}
