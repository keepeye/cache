<?php
/**
 * CacheTest.php.
 * @author keepeye <carlton.cheng@foxmail>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Keepeye\Cache\Tests;
use Keepeye\Cache\Cache;

class CacheTest extends \PHPUnit_Framework_TestCase {
    public function testGetDriver()
    {
        $cache = new Cache();
        $this->assertNotEmpty($cache->getDriver());
    }

    public function testSetDriver()
    {
        $cache = new Cache();
        $cache->setDriver("Redis");
        $this->assertEquals("Redis",$cache->getDriver());
    }

    public function testGetInstance()
    {
        $cache = new Cache();
        $cache->setDriver("File");
        $actual = $cache->getInstance();

        $this->assertInstanceOf("Keepeye\\Cache\\Drivers\\DriverInterface",$actual);
    }
}
 