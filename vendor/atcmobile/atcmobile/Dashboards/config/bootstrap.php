<?php

/**
 * Dashboard URL
 */

use Cake\Core\Configure;
use Atcmobapp\Core\Utility\StringConverter;
use Atcmobapp\Dashboards\Configure\DashboardsConfigReader;

if (!Configure::check('Site.dashboard_url')) {
    $converter = new StringConverter();
    Configure::write('Site.dashboard_url', $converter->urlToLinkString([
        'prefix' => 'admin',
        'plugin' => 'Atcmobapp/Dashboards',
        'controller' => 'Dashboards',
        'action' => 'dashboard',
    ]));
}

Configure::config('dashboards', new DashboardsConfigReader());
