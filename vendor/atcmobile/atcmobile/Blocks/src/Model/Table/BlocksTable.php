<?php

namespace Atcmobapp\Blocks\Model\Table;

use Cake\Cache\Cache;
use Cake\Database\Schema\TableSchema;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Atcmobapp\Core\Model\Table\AtcmobappTable;
use Atcmobapp\Core\Status;

/**
 * Block
 *
 * @category Blocks.Model
 * @package  Atcmobapp.Blocks.Model
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class BlocksTable extends AtcmobappTable
{

    /**
     * Find methods
     */
    public $findMethods = [
        'published' => true,
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
        $this->setEntityClass('Atcmobapp/Blocks.Block');

        $this->belongsTo('Regions', [
            'className' => 'Atcmobapp/Blocks.Regions',
            'foreignKey' => 'region_id',
            'counterCache' => true,
            'counterScope' => ['Blocks.status >=' => Status::PUBLISHED],
        ]);

        $this->addBehavior('CounterCache', [
            'Regions' => ['block_count'],
        ]);
        $this->addBehavior('Atcmobapp/Core.Publishable');
        $this->addBehavior('Atcmobapp/Core.Visibility');
        $this->addBehavior('ADmad/Sequence.Sequence', [
            'order' => 'weight',
            'scope' => ['region_id'],
        ]);
        $this->addBehavior('Atcmobapp/Core.Cached', [
            'groups' => [
                'blocks',
            ],
        ]);

        $this->addBehavior('Timestamp');
        $this->addBehavior('Atcmobapp/Core.Trackable');
        $this->addBehavior('Search.Search');

        $this->searchManager()
            ->value('region_id')
            ->add('regionAlias', 'Search.Finder', [
                'finder' => 'filterByRegionAlias',
            ])
            ->add('title', 'Search.Like', [
                'before' => true,
                'after' => true,
                'field' => $this->aliasField('title')
            ]);
    }

    protected function _initializeSchema(TableSchema $table)
    {
        $table->setColumnType('visibility_roles', 'encoded');
        $table->setColumnType('visibility_paths', 'encoded');
        $table->setColumnType('params', 'params');

        return parent::_initializeSchema($table);
    }

    public function afterSave()
    {
        Cache::clear(false, 'atcmobile_blocks');
    }

    public function findPublished(Query $query, array $options = [])
    {
        $options += ['roleId' => null];

        return $query->andWhere([
            $this->aliasField('status') . ' IN' => $this->status($options['roleId']),
        ]);
    }

    /**
     * Find Published blocks
     *
     * Query options:
     * - status Status
     * - regionId Region Id
     * - roleId Role Id
     * - cacheKey Cache key (optional)
     */
    public function findRegionPublished(Query $query, array $options = [])
    {
        $options += [
            'regionId' => null,
        ];

        return $query
            ->find('published', $options)
            ->find('byAccess', $options)
            ->where([
                'region_id IN' => $options['regionId']
            ]);
    }

    public function findFilterByRegionAlias(Query $query, array $options = [])
    {
        return $query
            ->find('published', $options)
            ->find('byAccess', $options)
            ->innerJoinWith('Regions')
            ->where([
                $this->Regions->aliasField('alias') => $options['regionAlias'],
            ]);
    }

}
