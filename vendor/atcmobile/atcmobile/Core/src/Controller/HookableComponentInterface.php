<?php

namespace Atcmobapp\Core\Controller;

/**
 * Interface HookableComponentInterface
 */
interface HookableComponentInterface
{

    /**
     * @param $name
     * @param array $config
     *
     * @return mixed
     */
    public function _loadHookableComponent($name, array $config);
}
