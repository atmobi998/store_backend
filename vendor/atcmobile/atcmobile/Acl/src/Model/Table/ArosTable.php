<?php

namespace Atcmobapp\Acl\Model\Table;

/**
 * AclAro Model
 *
 * @category Model
 * @package  Atcmobapp.Acl.Model
 * @version  1.0
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class ArosTable extends \Acl\Model\Table\ArosTable
{

    /**
     * Get a list of Role AROs
     *
     * @return array array of Aro.id indexed by Role.id
     */
    public function getRoles($roles)
    {
        $aros = $this->find('all', [
            'conditions' => [
                'Aros.model' => 'Roles',
                'Aros.foreign_key IN' => array_keys($roles->toArray()),
            ],
        ]);

        return collection($aros)->combine('foreign_key', 'id')->toArray();
    }
}
