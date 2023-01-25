<?php

namespace Atcmobapp\Core\Model\Behavior;

use Cake\ORM\Behavior;

/**
 * Aliasable Behavior
 *
 * Utility behavior to allow easy retrieval of records by id or its alias
 *
 * @package  Atcmobapp.Atcmobapp.Model.Behavior
 * @since    1.4
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class AliasableBehavior extends Behavior
{

    protected $_defaultConfig = [
        'id' => 'id',
        'alias' => 'alias',
    ];

    /**
     * _byIds
     *
     * @var array
     */
    protected $_byIds = [];

    /**
     * _byAlias
     *
     * @var array
     */
    protected $_byAlias = [];

    public function initialize(array $config)
    {
        $this->reload();
    }

    /**
     * reload
     *
     * @return void
     */
    public function reload()
    {
        $this->_byIds = $this->_table
            ->find('list', [
                'keyField' => $this->getConfig('id'),
                'valueField' => $this->getConfig('alias'),
            ])
            ->where([
                $this->_table->aliasField($this->getConfig('alias')) . ' !=' => '',
            ])
            ->toArray();
        $this->_byAlias = array_flip($this->_byIds);
    }

    /**
     * byId
     *
     * @param int $id
     * @return bool
     */
    public function byId($id)
    {
        if (!empty($this->_byIds[$id])) {
            return $this->_byIds[$id];
        }

        return false;
    }

    /**
     * byAlias
     *
     * @param string $alias
     * @return bool
     */
    public function byAlias($alias)
    {
        if (!empty($this->_byAlias[$alias])) {
            return $this->_byAlias[$alias];
        }

        return false;
    }

    /**
     * listById
     *
     * @return string
     */
    public function listById()
    {
        return $this->_byIds;
    }

    /**
     * listByAlias
     *
     * @return array
     */
    public function listByAlias()
    {
        return $this->_byAlias;
    }
}
