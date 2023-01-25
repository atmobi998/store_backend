<?php

namespace Atcmobapp\Core\TestSuite;

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Network\Request;
use Cake\ORM\Query;
use Cake\TestSuite\TestCase as CakeTestCase;
use Atcmobapp\Core\Event\EventManager;
use Atcmobapp\Core\PluginManager;
use Atcmobapp\Core\TestSuite\Constraint\QueryCount;
use PHPUnit_Util_InvalidArgumentHelper;

/**
 * AtcmobappTestCase class
 *
 * @category TestSuite
 * @package  Atcmobapp
 * @version  1.4
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @author   ATC Mobile Team <hotranan@gmail.com>
 * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
 * @link     http://metroeconomics.com
 */
class TestCase extends CakeTestCase
{
    protected $previousPlugins = [];

    public static function setUpBeforeClass()
    {
        Configure::write('Config.language', 'eng');
    }

    public static function tearDownAfterClass()
    {
        Configure::write('Config.language', Configure::read('Site.locale'));
    }

    /**
     * setUp
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        EventManager::instance(new EventManager);
        Configure::write('EventHandlers', []);

        PluginManager::unload('Atcmobapp/Install');
        PluginManager::load('Atcmobapp/Example', ['autoload' => true, 'path' => '../Example/']);
        Configure::write('Acl.database', 'test');

        $this->previousPlugins = Plugin::loaded();
    }

    public function tearDown()
    {
        parent::tearDown();

        // Unload all plugins that were loaded while running tests
        $diff = array_diff(Plugin::loaded(), $this->previousPlugins);
        foreach ($diff as $plugin) {
            PluginManager::unload($plugin);
        }
    }

    public function assertQueryCount($count, Query $query, $message = '')
    {
        if (!is_int($count)) {
            throw PHPUnit_Util_InvalidArgumentHelper::factory(1, 'integer');
        }

        $constraint = new QueryCount($count);

        static::assertThat($query, $constraint, $message);
    }

    /**
     * Helper method to create an test API request (with the appropriate detector)
     */
    protected function _apiRequest($params)
    {
        $request = new Request();
        $request->addParams($params);
        $request->addDetector('api', [
            'callback' => ['Atcmobapp\\Core\\Router', 'isApiRequest'],
        ]);

        return $request;
    }
}