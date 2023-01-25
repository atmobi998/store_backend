<?php

namespace Atcmobapp\Nodes\Model\Entity;

use Cake\ORM\Behavior\Translate\TranslateTrait;
use Cake\ORM\Entity;
use Atcmobapp\Acl\Traits\RowLevelAclTrait;

/**
 * @property string type Type of node
 * @property \Atcmobapp\Core\Link url
 */
class Node extends Entity
{

    use RowLevelAclTrait;

    use TranslateTrait;
}
