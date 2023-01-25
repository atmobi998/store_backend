<?php

namespace Atcmobapp\Menus\Model\Entity;

use Cake\ORM\Behavior\Translate\TranslateTrait;
use Cake\ORM\Entity;
use Atcmobapp\Acl\Traits\RowLevelAclTrait;

class Link extends Entity
{

    use RowLevelAclTrait;

    use TranslateTrait;

    protected $_virtual = ['path'];

    protected function _getPath()
    {
        return $this->link ? $this->link->getPath() : null;
    }
}
