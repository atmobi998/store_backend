<?php

namespace Atcmobapp\Core;

use DebugKit\DebugTimer;

if (!function_exists('\Atcmobapp\Core\linkFromLinkString')) {
    /**
     * @param string $link
     *
     * @return \Atcmobapp\Core\Link
     */
    function linkFromLinkString($link)
    {
        return Link::createFromLinkString($link);
    }
}

if (!function_exists('\Atcmobapp\Core\link')) {
    /**
     * @param array|string $url
     *
     * @return \Atcmobapp\Core\Link
     */
    function link($url)
    {
        return new Link($url);
    }
}

if (!function_exists('\Atcmobapp\Core\timerStart')) {
    function timerStart($name, $message = null)
    {
        if (!PluginManager::available('DebugKit')) {
            return;
        }

        DebugTimer::start($name, $message);
    }
}

if (!function_exists('\Atcmobapp\Core\timerStop')) {
    function timerStop($name)
    {
        if (!PluginManager::available('DebugKit')) {
            return;
        }

        DebugTimer::stop($name);
    }
}

if (!function_exists('\Atcmobapp\Core\time')) {
    function time(callable $callable, $name, $message = null)
    {
        timerStart($name, $message);

        call_user_func($callable);

        timerStop($name);
    }
}
