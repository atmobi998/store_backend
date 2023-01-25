<?php

namespace Atcmobapp\Extensions\Config;

return [
    'EventHandlers' => [
        'Atcmobapp/Extensions.ExtensionsEventHandler' => [
            'options' => [
                'priority' => 5,
            ],
        ],
        'Atcmobapp/Extensions.HookableComponentEventHandler' => [
            'options' => [
                'priority' => 5,
            ],
        ],
    ],
];
