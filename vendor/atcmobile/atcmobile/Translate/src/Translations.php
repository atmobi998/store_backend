<?php

/**
 * Translations
 *
 * @package  Atcmobapp.Translate.Lib
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
namespace Atcmobapp\Translate;

use Cake\Core\Configure;
use Atcmobapp\Core\Atcmobapp;

class Translations
{

    /**
     * Read configured Translate.models and hook the appropriate behaviors
     */
    public static function translateModels()
    {
        $path = 'prefix:admin/plugin:Atcmobapp%2fTranslate/controller:Translate/action:index/?id=:id&model={{model}}';
        foreach (Configure::read('Translate.models') as $encoded => $config) {
            $model = base64_decode($encoded);
            Atcmobapp::hookBehavior($model, 'Atcmobapp/Translate.Translate', $config);
            $action = str_replace('.', '.Admin/', $model . '/index');
            $url = str_replace('{{model}}', urlencode($model), $path);
            Atcmobapp::hookAdminRowAction(
                $action,
                __d('atcmobile', 'Translate'),
                [
                $url => [
                    'title' => false,
                    'options' => [
                        'icon' => 'translate',
                        'data-title' => __d('atcmobile', 'Translate'),
                    ],
                ]]
            );
        }
    }
}
