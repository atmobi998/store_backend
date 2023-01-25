<?php

namespace Atcmobapp\Taxonomy\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use Atcmobapp\Core\Model\Table\AtcmobappTable;

/**
 * @property TaxonomiesTable Taxonomies
 */
class VocabulariesTable extends AtcmobappTable
{

    public function initialize(array $config)
    {
        $this->addBehavior('ADmad/Sequence.Sequence', [
            'order' => 'weight',
        ]);

        $this->addBehavior('Timestamp');
        $this->addBehavior('Search.Search');
        $this->addBehavior('Atcmobapp/Core.Cached', [
            'groups' => ['taxonomy']
        ]);
        $this->belongsToMany('Atcmobapp/Taxonomy.Types', [
            'through' => 'Atcmobapp/Taxonomy.TypesVocabularies',
        ]);
        $this->hasMany('Atcmobapp/Taxonomy.Taxonomies', [
            'dependent' => true,
        ]);
    }

    /**
     * @param \Cake\Validation\Validator $validator
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->notBlank('title', __d('atcmobile', 'The title cannot be empty'))
            ->notBlank('alias', __d('atcmobile', 'The alias cannot be empty'));

        return parent::validationDefault($validator);
    }

    /**
     * @param \Cake\ORM\RulesChecker $rules
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(
            ['alias'],
            __d('atcmobile', 'That alias is already taken')
        ));

        return parent::buildRules($rules);
    }
}
