<?php

namespace Atcmobapp\Core\Model\Behavior;

use Cake\Cache\Cache;
use Cake\ORM\Behavior;
use InvalidArgumentException;

/**
 * Cached Behavior
 *
 * @category Behavior
 * @package  Atcmobapp.Atcmobapp.Model.Behavior
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class CachedBehavior extends Behavior
{
    protected $_defaultConfig = [
        'groups' => []
    ];

    /**
     * afterSave callback
     * @return void
     */
    public function afterSave()
    {
        $this->_deleteCachedFiles();
    }

    /**
     * afterDelete callback
     *
     * @return void
     */
    public function afterDelete()
    {
        $this->_deleteCachedFiles();
    }

    /**
     * Delete cache files matching prefix
     *
     * @return void
     */
    protected function _deleteCachedFiles()
    {
        foreach ($this->getConfig('groups') as $group) {
            try {
                $configs = Cache::groupConfigs($group);
                foreach ($configs[$group] as $config) {
                    Cache::clearGroup($group, $config);
                }
            } catch (InvalidArgumentException $e) {
                //Ignore invalid cache configs
            }
        }
    }
}
