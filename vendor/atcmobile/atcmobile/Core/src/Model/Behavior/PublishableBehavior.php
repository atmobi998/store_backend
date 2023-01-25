<?php

namespace Atcmobapp\Core\Model\Behavior;

use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Query;
use Cake\Utility\Hash;
use Atcmobapp\Core\Status;
use DateTime;

/**
 * Publishable Behavior
 *
 * Provides status and period filtering. Requires the following fields:
 *   - `status` integer value from `Status::statuses()
 *   - `publish_start` datetime indicates the start of publishing period
 *   - `publish_end` datetime indicates the end of publishing period
 *
 * @category Atcmobapp.Model.Behavior
 * @package  Atcmobapp.Atcmobapp.Model.Behavior
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 * @see      AtcmobappStatus
 */
class PublishableBehavior extends Behavior
{

    protected $_defaultConfig = [
        'admin' => false,
        'fields' => [
            'publish_start' => 'publish_start',
            'publish_end' => 'publish_end',
        ],
    ];

    /**
     * Setup
     *
     * Valid options:
     *
     *   `admin`: Enable/disable date filtering for users with Admin roles
     *   `fields`: Specifies the physical field name to use
     *
     * @return void
     */
    public function initialize(array $config)
    {
        $this->_AtcmobappStatus = new Status();
    }

    /**
     * Get status for conditions in query based on current user's role id
     *
     * @return array Array of status
     */
    public function status($roleId = null, $statusType = 'publishing', $accessType = 'public')
    {
        return $this->_AtcmobappStatus->status($roleId, $statusType, $accessType);
    }

    /**
     * Filter records based on period
     *
     * @return array Options passed to Model::find()
     */
    public function beforeFind(Event $event, Query $query, $options)
    {
        $table = $this->_table;
        $config = $this->getConfig();
        if (!empty($config['enabled'])) {
            return $query;
        }

        if ($config['admin'] === false && isset($_SESSION)) {
            // FIXME Avoid superglobals
            $roleId = Hash::get($_SESSION, 'Auth.User.role_id');
            if ($roleId == 1) {
                return $query;
            }
        }

        if (!$table->hasField($config['fields']['publish_start']) ||
            !$table->hasField($config['fields']['publish_end'])
        ) {
            return $query;
        }

        $date = isset($options['date']) ? $options['date'] : new DateTime();
        $start = $table->aliasField($config['fields']['publish_start']);
        $end = $table->aliasField($config['fields']['publish_end']);

        $query = $query->where([
            'OR' => [
                $start . ' IS' => null,
                [
                    $start . ' IS NOT' => null,
                    $start . ' <=' => $date,
                ],
            ],
        ]);

        $query = $query->andWhere([
            'OR' => [
                $end . ' IS' => null,
                [
                    $end . ' IS NOT' => null,
                    $end . ' >=' => $date,
                ],
            ],
        ]);

        return $query;
    }

    /**
     * Populate publish_start
     */
    public function beforeMarshal(Event $event, $options = [])
    {
        $data = $event->getData('data');
        if (array_key_exists('publish_start', $data)) {
            if (empty($data['publish_start'])) {
                $data['publish_start'] = new \DateTime();
            }
        }
        return true;
    }

}
