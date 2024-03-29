<?php

namespace Atcmobapp\Core\Routing\Route;

use Cake\Core\Configure;
use Cake\Routing\Route\Route;
use Cake\Utility\Hash;

/**
 * API Route class
 *
 * @package Atcmobapp.Atcmobapp.Routing.Route
 * @since 1.6
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link http://metroeconomics.com
 */
class ApiRoute extends Route
{

    public function __construct($template, $defaults = [], $options = [])
    {
        $options = Hash::merge([
            'api' => Configure::read('Atcmobapp.Api.path'),
            'prefix' => 'v[0-9.]+',
        ], $options);
        parent::__construct($template, $defaults, $options);
    }

    /**
     * Checks wether URL is an API route
     *
     * If the route is not an API route, we return false and let the next parser
     * to handle it.
     *
     * @param string $url The URL to attempt to parse.
     * @return mixed Boolean false on failure, otherwise an array or parameters
     * @see Route::parse()
     */
    public function parse($url)
    {
        $parsed = parent::parse($url);
        if (!isset($parsed['api']) || !isset($parsed['prefix'])) {
            return false;
        }
        $parsed['prefix'] = str_replace('.', '_', $parsed['prefix']);

        return $parsed;
    }

    /**
     * Checks if an URL array matches this route instance
     *
     * @param array $url An array of parameters to check matching with.
     * @return mixed Either a string URL for the parameters if they match or false.
     * @see Route::match()
     */
    public function match(array $url, array $context = [])
    {
        if (isset($url['prefix']) && isset($url['action'])) {
            $prefix = $url['prefix'];
            $url['prefix'] = str_replace('_', '.', $url['prefix']);
            $url['action'] = str_replace($prefix . '_', '', $url['action']);
        }
        $match = parent::match($url);
        if ($match && isset($url['action']) && $url['action'] == 'index') {
            $match = str_replace('/index', '', $match);
        }

        return $match;
    }
}
