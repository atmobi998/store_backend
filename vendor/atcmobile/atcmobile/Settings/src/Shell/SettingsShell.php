<?php

namespace Atcmobapp\Settings\Shell;

use Cake\Console\Shell;
use Cake\Core\App;
use Cake\Core\Configure;
use Atcmobapp\Core\Plugin;
use Atcmobapp\Core\PluginManager;

/**
 * Settings Shell
 *
 * Manipulates Settings via CLI
 *  ./Console/atcmobile settings.settings read -a
 *  ./Console/atcmobile settings.settings delete Some.key
 *  ./Console/atcmobile settings.settings write Some.key newvalue
 *  ./Console/atcmobile settings.settings write Some.key newvalue -create
 *
 * @category Shell
 * @package  Atcmobapp.Settings.Console.Command
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class SettingsShell extends Shell
{

    /**
     * Initialize
     */
    public function initialize()
    {
        $this->loadModel('Atcmobapp/Settings.Settings');
        Configure::write('Trackable.Auth.User', ['id' => 1]);
    }

    /**
     * getOptionParser
     */
    public function getOptionParser()
    {
        return parent::getOptionParser()
            ->setDescription('Atcmobapp Settings utility')
            ->addSubCommand('read', [
                'help' => __d('atcmobile', 'Displays setting values'),
                'parser' => [
                    'arguments' => [
                        'key' => [
                            'help' => __d('atcmobile', 'Setting key'),
                            'required' => false,
                        ],
                    ],
                    'options' => [
                        'all' => [
                            'help' => __d('atcmobile', 'List all settings'),
                            'short' => 'a',
                            'boolean' => true,
                        ]
                    ],
                ],
            ])
            ->addSubcommand('write', [
                'help' => __d('atcmobile', 'Write setting value for a given key'),
                'parser' => [
                    'arguments' => [
                        'key' => [
                            'help' => __d('atcmobile', 'Setting key'),
                            'required' => true,
                        ],
                        'value' => [
                            'help' => __d('atcmobile', 'Setting value'),
                            'required' => true,
                        ],
                    ],
                    'options' => [
                        'create' => [
                            'boolean' => true,
                            'short' => 'c',
                        ],
                        'title' => [
                            'short' => 't',
                        ],
                        'description' => [
                            'short' => 'd',
                        ],
                        'input_type' => [
                            'choices' => [
                                'text', 'textarea', 'checkbox', 'multiple',
                                'radio', 'file',
                            ],
                            'short' => 'i',
                        ],
                        'editable' => [
                            'short' => 'e',
                            'choices' => ['1', '0', 'y', 'n', 'Y', 'N'],
                        ],
                        'params' => [
                            'short' => 'p',
                        ],
                    ],
                ]
            ])
            ->addSubcommand('delete', [
                'help' => __d('atcmobile', 'Delete setting based on key'),
                'parser' => [
                    'arguments' => [
                        'key' => [
                            'help' => __d('atcmobile', 'Setting key'),
                            'required' => true,
                        ],
                    ],
                ]
            ])
            ->addSubcommand('update_app_version_info', [
                'help' => __d('atcmobile', 'Update app version string from git tag information'),
            ])
            ->addSubcommand('update_version_info', [
                'help' => __d('atcmobile', 'Update version string from git tag information'),
            ]);
    }

    /**
     * Read setting
     *
     * @param string $key
     * @return void
     */
    public function read()
    {
        if (empty($this->args)) {
            if ($this->params['all'] === true) {
                $key = null;
            } else {
                $this->out($this->OptionParser->help('get'));

                return;
            }
        } else {
            $key = $this->args[0];
        }
        $settings = $this->Settings->find('all', [
            'conditions' => [
                'Settings.key like' => '%' . $key . '%',
            ],
            'order' => 'Settings.weight asc',
        ]);
        $this->out("Settings: ", 2);
        foreach ($settings as $data) {
            $this->out(__d('atcmobile', "    %-30s: %s", $data->key, $data->value));
        }
        $this->out();
    }

    /**
     * Write setting
     *
     * @param string $key
     * @param string $val
     * @return void
     */
    public function write()
    {
        $key = $this->args[0];
        $val = $this->args[1];
        $setting = $this->Settings->find()
            ->select(['id', 'key', 'value'])
            ->where([
                'Settings.key' => $key,
            ])
            ->first();
        Configure::write('Trackable.Auth.User', ['id' => 1]);
        $this->out(__d('atcmobile', 'Updating %s', $key), 2);
        $ask = __d('atcmobile', "Confirm update");
        if ($setting || $this->params['create']) {
            $text = '-';
            if ($setting) {
                $text = __d('atcmobile', '- %s', $setting->value);
            }
            $this->warn($text);
            $this->success(__d('atcmobile', '+ %s', $val));

            if ('y' == $this->in($ask, ['y', 'n'], 'n')) {
                $keys = [
                    'title' => null, 'description' => null,
                    'input_type' => null, 'editable' => null, 'params' => null,
                ];
                $options = array_intersect_key($this->params, $keys);

                if (isset($options['editable'])) {
                    $options['editable'] = in_array(
                        $options['editable'],
                        ['y', 'Y', '1']
                    );
                }

                $this->Settings->write($key, $val, $options);
                $this->success(__d('atcmobile', 'Setting updated'));
            } else {
                $this->warn(__d('atcmobile', 'Cancelled'));
            }
        } else {
            $this->warn(__d('atcmobile', 'Key: %s not found', $key));
        }
    }

    /**
     * Delete setting
     *
     * @param string $key
     * @return void
     */
    public function delete()
    {
        $key = $this->args[0];
        $setting = $this->Settings->find()
            ->select(['id', 'key', 'value'])
            ->where([
                'Settings.key' => $key,
            ])
            ->first();
        $this->out(__d('atcmobile', 'Deleting %s', $key), 2);
        $ask = __d('atcmobile', 'Delete?');
        if ($setting) {
            if ('y' == $this->in($ask, ['y', 'n'], 'n')) {
                $this->Settings->deleteKey($setting->key);
                $this->success(__d('atcmobile', 'Setting deleted'));
            } else {
                $this->warn(__d('atcmobile', 'Cancelled'));
            }
        } else {
            $this->warn(__d('atcmobile', 'Key: %s not found', $key));
        }
    }

    /**
     * Update Atcmobapp.version in settings
     */
    public function updateVersionInfo()
    {
        return $this->Settings->updateVersionInfo();
    }

    /**
     * Update Atcmobapp.appVersion in settings
     */
    public function updateAppVersionInfo()
    {
        return $this->Settings->updateAppVersionInfo();
    }
}
