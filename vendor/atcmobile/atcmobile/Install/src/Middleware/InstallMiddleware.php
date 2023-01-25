<?php

namespace Atcmobapp\Install\Middleware;

use Cake\Routing\Router;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\RedirectResponse;

/**
 * Class InstallMiddleware
 */
class InstallMiddleware
{

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, $next)
    {
        $plugin = $request->getParam('plugin');
        if (!in_array($plugin, ['Atcmobapp/Install', 'DebugKit'])) {
            $url = [
                'plugin' => 'Atcmobapp/Install',
                'controller' => 'Install',
                'action' => 'index',
            ];

            return new RedirectResponse(Router::url($url), 307);
        }

        return $next($request, $response);
    }
}
