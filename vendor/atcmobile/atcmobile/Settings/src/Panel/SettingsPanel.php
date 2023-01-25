<?php

namespace Atcmobapp\Settings\Panel;

use Cake\Core\Configure;
use DebugKit\DebugPanel;

class SettingsPanel extends DebugPanel
{

    public $plugin = 'Atcmobapp/Settings';

    public function data()
    {
        return [
            'settings' => Configure::read()
        ];
    }
}
