<?php

use Phinx\Seed\AbstractSeed;

class SettingsSeed extends AbstractSeed
{

    public $records = [
        [
            'key' => 'Site.title',
            'value' => 'Atcmobapp',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => '1',
            'weight' => '1',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Site.tagline',
            'value' => 'ATC Mobile CMS.',
            'title' => '',
            'description' => '',
            'input_type' => 'textarea',
            'editable' => '1',
            'weight' => '2',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Site.email',
            'value' => 'hotranan@gmail.com',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => '1',
            'weight' => '3',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Site.status',
            'value' => '1',
            'title' => '',
            'description' => '',
            'input_type' => 'checkbox',
            'editable' => '1',
            'weight' => '6',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Service.akismet_key',
            'value' => 'akismet_key',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => '1',
            'weight' => '11',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Service.recaptcha_public_key',
            'value' => 'recaptcha_public_key',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => '1',
            'weight' => '12',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Service.recaptcha_private_key',
            'value' => 'recaptcha_private_key',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => '1',
            'weight' => '13',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Service.akismet_url',
            'value' => 'http://metroeconomics.com',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => '1',
            'weight' => '10',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Site.theme',
            'value' => 'Atcmobapp/Core',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => '0',
            'weight' => '14',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Site.feed_url',
            'value' => '',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => '0',
            'weight' => '15',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Reading.nodes_per_page',
            'value' => '5',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => '1',
            'weight' => '16',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Comment.level',
            'value' => '6',
            'title' => '',
            'description' => 'levels deep (threaded comments)',
            'input_type' => '',
            'editable' => '1',
            'weight' => '18',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Comment.feed_limit',
            'value' => '20',
            'title' => '',
            'description' => 'number of comments to show in feed',
            'input_type' => '',
            'editable' => '1',
            'weight' => '19',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Site.locale',
            'value' => 'en_US',
            'title' => '',
            'description' => '',
            'input_type' => 'text',
            'editable' => '1',
            'weight' => '20',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Reading.date_time_format',
            'value' => 'EEE, MMM dd yyyy HH:mm:ss',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => '1',
            'weight' => '21',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Comment.date_time_format',
            'value' => 'MMM dd, yyyy',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => '1',
            'weight' => '22',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Site.timezone',
            'value' => 'UTC',
            'title' => '',
            'description' => 'Provide a valid timezone identifier as specified in https://php.net/manual/en/timezones.php',
            'input_type' => 'select',
            'editable' => '1',
            'weight' => '4',
            'created_by' => 1,
            'params' => 'optionClass=Atcmobapp/Settings.Timezones'
        ],
        [
            'key' => 'Hook.bootstraps',
            'value' => 'Atcmobapp/Settings,Atcmobapp/Contacts,Atcmobapp/Nodes,Atcmobapp/Meta,Atcmobapp/Mobapps,Atcmobapp/Menus,Atcmobapp/Users,Atcmobapp/Blocks,Atcmobapp/Taxonomy,Atcmobapp/FileManager,Atcmobapp/Wysiwyg,Atcmobapp/Dashboards,Atcmobapp/Ckeditor,Atcmobapp/Comments',
            'title' => '',
            'description' => '',
            'input_type' => '',
            'editable' => '0',
            'weight' => '23',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Comment.email_notification',
            'value' => '1',
            'title' => 'Enable email notification',
            'description' => '',
            'input_type' => 'checkbox',
            'editable' => '1',
            'weight' => '24',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Access Control.multiRole',
            'value' => '0',
            'title' => 'Enable Multiple Roles',
            'description' => '',
            'input_type' => 'checkbox',
            'editable' => '1',
            'weight' => '25',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Access Control.rowLevel',
            'value' => '0',
            'title' => 'Row Level Access Control',
            'description' => '',
            'input_type' => 'checkbox',
            'editable' => '1',
            'weight' => '26',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Access Control.autoLoginDuration',
            'value' => '+1 week',
            'title' => '"Remember Me" Duration',
            'description' => 'Eg: +1 day, +1 week. Leave empty to disable.',
            'input_type' => 'text',
            'editable' => '1',
            'weight' => '27',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Access Control.models',
            'value' => '',
            'title' => 'Models with Row Level Acl',
            'description' => 'Select models to activate Row Level Access Control on',
            'input_type' => 'multiple',
            'editable' => '1',
            'weight' => '26',
            'created_by' => 1,
            'params' => 'multiple=checkbox
options={"Atcmobapp/Nodes.Nodes": "Nodes", "Atcmobapp/Blocks.Blocks": "Blocks", "Atcmobapp/Menus.Menus": "Menus", "Atcmobapp/Menus.Links": "Links"}'
        ],
        [
            'key' => 'Site.ipWhitelist',
            'value' => '127.0.0.1',
            'title' => 'Whitelisted IP Addresses',
            'description' => 'Separate multiple IP addresses with comma',
            'input_type' => 'text',
            'editable' => '1',
            'weight' => '27',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Site.asset_timestamp',
            'value' => 'force',
            'title' => 'Asset timestamp',
            'description' => 'Appends a timestamp which is last modified time of the particular file at the end of asset files URLs (CSS, JavaScript, Image). Useful to prevent visitors to visit the site with an outdated version of these files in their browser cache.',
            'editable' => 1,
            'input_type' => 'radio',
            'weight' => 28,
            'created_by' => 1,
            'params' => 'options={"0": "Disabled", "1": "Enabled in debug mode only", "force": "Always enabled"}',
        ],
        [
            'key' => 'Site.admin_theme',
            'value' => 'Atcmobapp/Core',
            'title' => 'Administration Theme',
            'description' => '',
            'input_type' => 'text',
            'editable' => '1',
            'weight' => '29',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Site.home_url',
            'value' => '',
            'title' => 'Home Url',
            'description' => 'Default action for home page in link string format.',
            'input_type' => 'text',
            'editable' => '1',
            'weight' => '30',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Atcmobapp.version',
            'value' => '',
            'title' => 'Atcmobapp Version',
            'description' => '',
            'input_type' => 'text',
            'editable' => '0',
            'weight' => '31',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Atcmobapp.appVersion',
            'value' => '3.9',
            'title' => 'App Version',
            'description' => '',
            'input_type' => 'text',
            'editable' => '0',
            'weight' => '31',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Theme.bgImagePath',
            'value' => '',
            'title' => 'Background Image',
            'description' => '',
            'input_type' => 'file',
            'editable' => '1',
            'weight' => '32',
            'created_by' => 1,
            'params' => ''
        ],
        [
            'key' => 'Access Control.splitSession',
            'value' => '',
            'title' => 'Separate front-end and admin session',
            'description' => '',
            'input_type' => 'checkbox',
            'editable' => '1',
            'weight' => '32',
            'created_by' => 1,
            'params' => ''
        ],
    ];

    public function run()
    {
        $Table = $this->table('settings');
        $Table->insert($this->records)->save();
    }
}
