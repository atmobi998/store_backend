<?php

namespace Atcmobapp\Users\Model\Table;

use Atcmobapp\Core\Model\Table\AtcmobappTable;

class RolesTable extends AtcmobappTable
{

    /**
     * Display fields for this model
     *
     * @var array
     */
    protected $_displayFields = [
        'title',
        'alias',
    ];

    public function initialize(array $config)
    {
        $this->addBehavior('Acl.Acl', [
            'className' => 'Atcmobapp/Core.AtcmobappAcl',
            'type' => 'requester'
        ]);
        $this->addBehavior('Search.Search');
        $this->addBehavior('Atcmobapp/Core.Trackable');
        $this->addBehavior('Atcmobapp/Core.Aliasable');
    }
}
