<?php

use Atcmobapp\Dashboards\AtcmobappDashboard;

return [
    'dashboards.blogfeed' => [
        'title' => __d('atcmobile', 'Atcmobapp News'),
        'cell' => 'Atcmobapp/Dashboards.BlogFeed::dashboard',
        'column' => AtcmobappDashboard::RIGHT,
        'access' => ['superadmin'],
    ],
];
