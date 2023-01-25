<?php

namespace Atcmobapp\Mobapps\View\Helper;

use Cake\Collection\Collection;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Event\Event;
use Cake\Utility\Hash;
use Cake\View\Helper;
use Cake\View\View;
use Atcmobapp\Core\Atcmobapp;
use Atcmobapp\Core\Utility\StringConverter;
use Atcmobapp\Mobapps\Model\Entity\Mobapp;

/**
 * Mobapps Helper
 *
 * @category Helper
 * @package  Atcmobapp.Mobapps
 * @version  1.0
 * @author   SP.NET Team <admin@streetplan.net>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://streetplan.net
 */
class MobappsHelper extends Helper
{

    /**
     * Other helpers used by this helper
     *
     * @var array
     * @access public
     */
    public $helpers = [
        'Atcmobapp/Core.Url',
        'Atcmobapp/Core.Layout',
        'Atcmobapp/Core.Html',
        'Time',
        'Html',
        'Form',
    ];

    /**
     * Current Mobapp
     *
     * @var \Atcmobapp\Mobapps\Model\Entity\Mobapp
     * @access public
     */
    public $street = null;

    /**
     * StringConverter instance
     *
     * @var StringConverter
     */
    protected $_converter = null;

    /**
     * constructor
     */
    public function __construct(View $view, $settings = [])
    {
        parent::__construct($view);
        $this->_converter = new StringConverter();
        $this->_setupEvents();
    }

    /**
     * setup events
     */
    protected function _setupEvents()
    {
        $events = [
            'Helper.Layout.beforeFilter' => [
                'callable' => 'filter', 'passParams' => true,
            ],
        ];
        $eventManager = $this->_View->getEventManager();
        foreach ($events as $name => $config) {
            $eventManager->on($name, $config, [$this, 'filter']);
        }
    }

    /**
     * Show streets list
     *
     * @param string $alias Mobapp query alias
     * @param array $options (optional)
     * @return string
     */
    public function streetList($alias, $options = [])
    {

    }

    /**
     * Filter content for Mobapps
     *
     * Replaces [street:unique_name_for_query] or [n:unique_name_for_query] with Mobapps list
     *
     * @param Event $event
     * @return string
     */
    public function filter(Event $event, $options = [])
    {

    }

    /**
     * Set current Mobapp
     *
     * @param array $street
     * @return void
     */
    public function set($street)
    {

    }

    /**
     * Get value of a Mobapp field
     *
     * @param string $field
     * @return string
     */
    public function field($field = 'id', $value = null)
    {

    }

    /**
     * Mobapp info
     *
     * @param array $options
     * @return string
     */
    public function info($options = [])
    {

    }

    /**
     * Mobapp excerpt (summary)
     *
     * Options:
     * - `element`: Element to use when rendering excerpt
     * - `body`: Extract first paragraph from body as excerpt. Default is `false`
     *
     * @param array $options
     * @return string
     */
    public function excerpt($options = [])
    {

    }

    /**
     * Mobapp body
     *
     * @param array $options
     * @return string
     */
    public function body($options = [])
    {

    }

    /**
     * Mobapp more info
     *
     * @param array $options
     * @return string
     */
    public function moreInfo($options = [])
    {
        $_options = [
            'element' => 'Atcmobapp/Mobapps.street_more_info',
        ];
        $options = array_merge($_options, $options);

        $output = $this->Layout->hook('beforeMobappMoreInfo');
        $output .= $this->_View->element($options['element']);
        $output .= $this->Layout->hook('afterMobappMoreInfo');

        return $output;
    }

    /**
     * Convenience method to generate url to a street or current street
     *
     * @param \Atcmobapp\Mobapps\Model\Entity\Mobapp $street Mobapp data
     * @param bool $full
     * @return string
     */
    public function url(Mobapp $street = null, $full = false)
    {
        if ($street === null) {
            $street = $this->street;
        }

        return $this->Url->build($street->url, $full);
    }

    /**
     * Return formatted date
     *
     * @param \Cake\I18n\FrozenTime $date date to format
     * @return string
     */
    public function date($date)
    {
        $tz = $this->getView()->getRequest()->getSession()->read('Auth.User.timezone') ?: Configure::read('Site.timezone');

        return $this->Time->format($date, Configure::read('Reading.date_time_format'), null, $tz);
    }

    /**
     * Return all term links
     *
     * @return array
     */
    public function streetTermLinks()
    {

    }

    /**
     * Check if comments plugin is enable
     *
     * @return bool
     */
    public function commentsEnabled()
    {

    }
}
