<?php

namespace Atcmobapp\Core\View\Helper;

use Cake\Log\Log;
use Cake\Utility\Hash;
use Cake\View\Helper;
use Cake\View\View;
use Atcmobapp\Extensions\AtcmobappTheme;

/**
 * Theme Helper
 *
 * @category Helper
 * @package  Atcmobapp.Atcmobapp.View.Helper
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class ThemeHelper extends Helper
{

    protected $_themeSettings = [];

    protected $_iconMap = [];

    /**
     * Other helpers used by this helper
     *
     * @var array
     * @access public
     */
    public $helpers = [
    ];

    /**
     * ThemeHelper constructor.
     * @param View $View
     * @param array $settings
     */
    public function __construct(View $View, $settings = [])
    {
        $themeConfig = AtcmobappTheme::config($View->getTheme());
        $this->_themeSettings = $themeConfig['settings'];

        $this->_iconMap = $this->_themeSettings['icons'];
        $prefix = $View->getRequest()->getParam('prefix');
        if (isset($this->_themeSettings['prefixes'][$prefix]['helpers']['Html']['icons'])) {
            $this->_iconMap = Hash::merge(
                $this->_iconMap,
                $this->_themeSettings['prefixes'][$prefix]['helpers']['Html']['icons']
            );
        }

        parent::__construct($View, $settings);
    }

    /**
     * Helper method to retrieve css settings as configured in theme.json
     *
     * @param string $class Name of class/configuration to retrieve
     * @return string
     */
    public function getCssClass($class = null)
    {
        if ($class) {
            $class = '.' . $class;
        }

        return $this->settings('css' . $class);
    }

    /**
     * Helper method to retrieve theme settings as configured in theme.json
     *
     * @param string $key Name of class/configuration to retrieve
     * @return string
     */
    public function settings($key = null)
    {
        $theme = $this->_View->getTheme() ?: 'default';
        if (empty($this->_themeSettings)) {
            Log::debug(sprintf('Invalid settings for theme "%s"', $theme));

            return [];
        }
        if ($key === null) {
            return $this->_themeSettings;
        }

        return Hash::get($this->_themeSettings, $key);
    }

    /**
     * Returns a mapped icon identifier based on current active theme
     *
     * @param string $icon Icon name (without prefix)
     * @return string a mapped icon identifier
     */
    public function getIcon($icon)
    {
        $mapped = $icon;
        if (isset($this->_iconMap[$icon])) {
            $mapped = $this->_iconMap[$icon];
        }

        return $mapped;
    }
}
