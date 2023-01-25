<?php

namespace Atcmobapp\Blocks\Model\Entity;

use Cake\ORM\Behavior\Translate\TranslateTrait;
use Cake\ORM\Entity;
use Atcmobapp\Acl\Traits\RowLevelAclTrait;

class Block extends Entity
{

    use RowLevelAclTrait;

    use TranslateTrait;
}
