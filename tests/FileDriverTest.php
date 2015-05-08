<?php
/**
 * FileDriverTest.php.
 * @author keepeye <carlton.cheng@foxmail>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Keepeye\Cache\Tests;

use Keepeye\Cache\Drivers\FileDriver;

class FileDriverTest extends \PHPUnit_Framework_TestCase {
    private $instance;

    public function setUp()
    {
        $this->instance = new FileDriver(array(
            "dir" => __DIR__."/../cache"
        ));
    }


    public function testPut()
    {
        $this->instance->put("t1","v1",1);
        $this->assertEquals("v1",$this->instance->get("t1"));
    }

    public function testGetExpireAt()
    {
        $this->instance->put("t1","v1",100);
        $this->assertTrue(time()<$this->instance->getExpireAt("t1"));
    }

    public function testForget()
    {
        $this->instance->put("t1","v1",100);
        $this->assertEquals("v1",$this->instance->get("t1"));
        $this->instance->forget("t1");
        $this->assertNull($this->instance->get("v1"));
    }

    public function testForever()
    {
        $this->instance->forever("t1","v1");
        $this->assertNotEmpty($this->instance->get("t1"));
    }

    public function testFlush()
    {
        $this->instance->put("t1","v1",100);
        $this->assertNotEmpty($this->instance->get("t1"));
        $this->instance->flush();
        $this->assertNull($this->instance->get("t1"));
    }

    public function tearDown()
    {
        $this->instance->flush();
    }
}
 