<?php
/**
 * DriverInterface.php.
 * @author keepeye <carlton.cheng@foxmail>
 * @license http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Keepeye\Cache\Drivers;


interface DriverInterface {
    /**
     * 通过$key获取指定缓存.
     *
     * @param  string  $key
     * @return mixed
     */
    public function get($key);

    /**
     * 按指定时间存储一个缓存值.
     *
     * @param  string  $key 缓存key
     * @param  mixed   $value 缓存值
     * @param  int     $expire 缓存有效时间，单位：秒
     * @return void
     */
    public function put($key, $value, $expire);


    /**
     * 存储一个永久的缓存.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function forever($key, $value);

    /**
     * 删除一个缓存.
     *
     * @param  string  $key
     * @return void
     */
    public function forget($key);

    /**
     * 删除所有缓存.
     *
     * @return void
     */
    public function flush();

    /**
     * 获取缓存key的前缀.
     *
     * @return string
     */
    public function getPrefix();

    /**
     * 获取一个缓存的到期时间
     * @param $key
     * @return int
     */
    public function getExpireAt($key);
} 