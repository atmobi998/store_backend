<?php

namespace Atcmobapp\Dashboards\Model\Table;

use Atcmobapp\Core\Model\Table\AtcmobappTable;

/**
 * Dashboard Model
 *
 * @category Dashboards.Model
 * @package  Atcmobapp.Dashboards.Model
 * @version  2.2
 * @author   Walther Lalk <emailme@waltherlalk.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class DashboardsTable extends AtcmobappTable
{

    public function initialize(array $config)
    {
        $this->setTable('dashboards');
        $this->addBehavior('Timestamp');
        $this->addBehavior('ADmad/Sequence.Sequence', [
            'order' => 'weight',
            'scope' => ['user_id', 'column'],
        ]);
        $this->belongsTo('Users', [
            'className' => 'Atcmobapp/Users.Users'
        ]);
        $this->getConnection()->getDriver()->enableAutoQuoting();
    }
}
