<?php

namespace Atcmobapp\Extensions\Exception;

use Atcmobapp\Core\Exception\Exception;

class ControllerNotHookableException extends Exception
{

    protected $_messageTemplate = 'Controller %s is not hookable, implement HookableComponentInterface';
}
