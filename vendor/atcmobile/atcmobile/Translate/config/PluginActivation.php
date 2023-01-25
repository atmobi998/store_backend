<?php

/**
 * Translate Activation
 *
 * @package  Atcmobapp.Translate
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
namespace Atcmobapp\Translate\Config;

use Cake\ORM\TableRegistry;
use Atcmobapp\Core\PluginManager;

class PluginActivation
{

    /**
     * onActivate will be called if this returns true
     *
     * @param  object $controller Controller
     * @return bool
     */
    public function beforeActivation(&$controller)
    {
        return true;
    }

    /**
     * Called after activating the plugin in ExtensionsPluginsController::admin_toggle()
     *
     * @param object $controller Controller
     * @return void
     */
    public function onActivation(&$controller)
    {
        $Acos = TableRegistry::get('Atcmobapp/Acl.Acos');
        $Acos->addAco('Atcmobapp\Translate/Admin/Translate/index');
        $Acos->addAco('Atcmobapp\Translate/Admin/Translate/edit');
        $Acos->addAco('Atcmobapp\Translate/Admin/Translate/delete');
        $AtcmobappPlugin = new PluginManager();
        $AtcmobappPlugin->migrate('Atcmobapp/Translate');
    }

    /**
     * onDeactivate will be called if this returns true
     *
     * @param  object $controller Controller
     * @return bool
     */
    public function beforeDeactivation(&$controller)
    {
        return true;
    }

    /**
     * Called after deactivating the plugin in ExtensionsPluginsController::admin_toggle()
     *
     * @param object $controller Controller
     * @return void
     */
    public function onDeactivation(&$controller)
    {
        $Acos = TableRegistry::get('Atcmobapp/Acl.Acos');
        $Acos->removeAco('Atcmobapp\Translate');
    }
}
