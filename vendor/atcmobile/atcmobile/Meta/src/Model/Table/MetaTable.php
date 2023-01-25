<?php

namespace Atcmobapp\Meta\Model\Table;

use Atcmobapp\Core\Model\Table\AtcmobappTable;
use Atcmobapp\Meta\Model\Entity\Meta;

/**
 * Meta
 *
 * @category Meta.Model
 * @package  Atcmobapp.Meta
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class MetaTable extends AtcmobappTable
{
    protected $_quoted;

    protected $_displayFields = [
        'key',
        'value',
    ];

    protected $_editFields = [
        'key',
        'value',
    ];

    public function initialize(array $config)
    {
        $this->setTable('meta');
        $this->setEntityClass(Meta::class);
        $this->addBehavior('Timestamp');
        $this->addBehavior('Atcmobapp/Core.Trackable');
        $this->addBehavior('Atcmobapp/Core.Cached', [
            'groups' => [
                'settings',
            ],
        ]);
        $this->addBehavior('Search.Search');
    }

    /**
     * @return void
     */
    public function beforeSave()
    {
        $this->_quoted = $this->getConnection()
            ->getDriver()
            ->enableAutoQuoting();
        $this->getConnection()
            ->getDriver()
            ->enableAutoQuoting();
    }

    /**
     * @return void
     */
    public function afterSave()
    {
        $this->getConnection()
            ->getDriver()
            ->enableAutoQuoting($this->_quoted);
    }
}
