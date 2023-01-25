<?php

namespace Atcmobapp\Core;

use ArrayAccess;
use Cake\Core\Exception\Exception;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;

/**
 * Status
 *
 * @package  Atcmobapp.Atcmobapp.Lib
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class Status implements ArrayAccess
{

    const UNPUBLISHED = 0;

    const PUBLISHED = 1;

    const PREVIEW = 2;

    const PENDING = 0;

    const APPROVED = 1;

    const PROMOTED = 1;

    const UNPROMOTED = 0;

    protected $_statuses = [];

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_statuses = [
            'publishing' => [
                self::UNPUBLISHED => __d('atcmobile', 'Unpublished'),
                self::PUBLISHED => __d('atcmobile', 'Published'),
                self::PREVIEW => __d('atcmobile', 'Preview'),
            ],
            'approval' => [
                self::APPROVED => __d('atcmobile', 'Approved'),
                self::PENDING => __d('atcmobile', 'Pending'),
            ],
        ];
        $event = Atcmobapp::dispatchEvent('Atcmobapp.Status.setup', null, $this);
    }

    public function offsetExists($offset)
    {
        return isset($this->_statuses[$offset]);
    }

    public function &offsetGet($offset)
    {
        $result = null;
        if (isset($this->_statuses[$offset])) {
            $result =& $this->_statuses[$offset];
        }

        return $result;
    }

    public function offsetSet($offset, $value)
    {
        $this->_statuses[$offset] = $value;
    }

    public function offsetUnset($offset)
    {
        if (isset($this->_statuses[$offset])) {
            unset($this->_statuses[$offset]);
        }
    }

    /**
     * Returns a list of status id and its descriptions
     *
     * @return array List of status id and its descriptions
     */
    public function statuses($type = 'publishing')
    {
        if (array_key_exists($type, $this->_statuses)) {
            return $this->_statuses[$type];
        }

        return [];
    }

    /**
     * Gets valid statuses based on type
     *
     * @param string $roleId Status type if applicable
     * @return array Array of statuses
     */
    public function status($roleId = null, $statusType = 'publishing', $accessType = 'public')
    {
        $values = $this->_defaultStatus($roleId, $statusType);
        $data = compact('statusType', 'accessType', 'values');
        $event = Atcmobapp::dispatchEvent('Atcmobapp.Status.status', null, $data);
        if (array_key_exists('values', $event->getData())) {
            return $event->getData('values');
        } else {
            return $values;
        }
    }

    /**
     * Default status
     */
    protected function _defaultStatus($roleId, $statusType)
    {
        $status[$statusType] = [self::PUBLISHED];
        $allow = false;

        if ($roleId && $roleId !== 1) {
            $Permission = TableRegistry::get('Acl.Permissions');
            try {
                $allow = $Permission->check(['model' => 'Roles', 'foreign_key' => $roleId], 'controllers/Atcmobapp\Nodes/Admin/Nodes/edit');
            } catch (Exception $e) {
                Log::error($e->getMessage());
            }
        }

        switch ($statusType) {
            case 'publishing':
                if ($roleId === 1 || $allow) {
                    $status[$statusType][] = self::PREVIEW;
                }
                break;
        }

        return $status[$statusType];
    }

    /**
     * Get the status id from description
     *
     * @return int|mixed Status Id
     */
    public function byDescription($title, $statusType = 'publishing', $strict = true)
    {
        if (array_key_exists($statusType, $this->_statuses)) {
            return array_search($title, $this->_statuses[$statusType], $strict);
        }

        return false;
    }

    /**
     * Get the description from id
     *
     * @return string|null Status Description
     */
    public function byId($id, $statusType = 'publishing')
    {
        if (isset($this->_statuses[$statusType][$id])) {
            return $this->_statuses[$statusType][$id];
        }

        return null;
    }
}
