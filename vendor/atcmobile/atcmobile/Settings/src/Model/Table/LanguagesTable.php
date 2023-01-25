<?php

namespace Atcmobapp\Settings\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Atcmobapp\Core\Model\Table\AtcmobappTable;

/**
 * Language
 *
 * @category Model
 * @package  Atcmobapp.Settings.Model
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class LanguagesTable extends AtcmobappTable
{

    /**
     * Initialize
     */
    public function initialize(array $config)
    {
        $this->addBehavior('Atcmobapp/Core.Trackable');
        $this->addBehavior('ADmad/Sequence.Sequence', [
            'order' => 'weight',
        ]);
        $this->addBehavior('Search.Search');
        $this->addBehavior('Timestamp');

        $likeOptions = [
            'before' => true,
            'after' => true,
        ];
        $this->searchManager()
            ->add('title', 'Search.Like', $likeOptions)
            ->add('alias', 'Search.Like', $likeOptions)
            ->add('locale', 'Search.Like', $likeOptions);
    }

    public function validationDefault(Validator $validator)
    {
        $validator
            ->notBlank('title', __d('atcmobile', 'Title cannot be empty.'))
            ->notBlank('native', __d('atcmobile', 'Native cannot be empty.'))
            ->notBlank('alias', __d('atcmobile', 'Alias cannot be empty.'))
            ->notBlank('locale', __d('atcmobile', 'Locale cannot be empty.'));

        return $validator;
    }

    public function buildRules(RulesChecker $rules)
    {
        $rules
            ->add($rules->isUnique(
                ['locale'],
                __d('atcmobile', 'That locale is already taken')
            ))
            ->add($rules->isUnique(
                ['alias'],
                __d('atcmobile', 'That alias is already taken')
            ));

        return $rules;
    }

    public function findActive(Query $query)
    {
        $query
            ->select(['id', 'alias', 'locale'])
            ->where(['status' => true])
            ->formatResults(function ($results) {
                $formatted = [];
                foreach ($results as $row) {
                    $formatted[$row->alias] = ['locale' => $row->locale];
                }

                return $formatted;
            });

        return $query;
    }
}
