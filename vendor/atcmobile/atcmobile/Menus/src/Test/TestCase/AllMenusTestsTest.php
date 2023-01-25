<?php
namespace Atcmobapp\Menus\Test\TestCase;

use Atcmobapp\TestSuite\AtcmobappTestCase;

class AllMenusTestsTest extends PHPUnit_Framework_TestSuite
{

    /**
     * suite
     *
     * @return CakeTestSuite
     */
    public static function suite()
    {
        $suite = new CakeTestSuite('All Menus tests');
        $suite->addTestDirectoryRecursive(Plugin::path('Menus') . 'Test' . DS . 'Case' . DS);

        return $suite;
    }
}
