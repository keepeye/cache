<?php
/**
 * Cache.php
 * @author: keepeye <carlton.cheng@foxmail.com>
 */

namespace Keepeye\Cache;

/**
 * Class Cache
 * 缓存管理器
 *
 * @package Keepeye\Cache
 */
class Cache {
    private $driver="FileDriver";

    /**
     * 设置驱动名称
     *
     * @param $driver
     */
    public function setDriver($driver)
    {
        $this->driver = $driver;
    }

    /**
     * 获取驱动名称
     *
     * @return string
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * 获取一个驱动实例
     *
     * @param array $options
     * @return mixed
     */
    public function getInstance($options=array())
    {
        $class = "Keepeye\\Cache\\Drivers\\".$this->getDriver()."Driver";
        return new $class($options);
    }
}