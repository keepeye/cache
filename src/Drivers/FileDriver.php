<?php
/**
 * File.php
 * @author: keepeye <carlton.cheng@foxmail.com>
 */

namespace Keepeye\Cache\Drivers;


class FileDriver implements DriverInterface{
    private $dir="./cache";
    private $depth=2;

    public function __construct($options=array())
    {
        if (isset($options['dir'])) $this->dir = $options['dir'];
        if (isset($options['depth'])) $this->dir = $options['depth'];
    }

    /**
     * 读取一个指定的缓存数据
     *
     * @param string $key
     * @return mixed|null
     */
    public function get($key)
    {
        $payload = $this->getPayload($key);
        return $payload['data'];
    }

    /**
     * 获取一个缓存的过期时间
     *
     * @param $key
     * @return mixed
     */
    public function getExpireAt($key)
    {
        $payload = $this->getPayload($key);
        return $payload['expireAt'];
    }

    /**
     * 获取缓存详细信息
     *
     * @param $key
     * @return array
     */
    protected function getPayload($key)
    {
        $path = $this->path($key);
        if (!file_exists($path)) {
            return array("data"=>null,"expireAt">null);
        }

        $contents = file_get_contents($path);

        try {
            $expire = substr($contents, 0, 10);
        } catch (\Exception $e) {
            return array("data"=>null,"expireAt"=>null);
        }

        if (time() > $expire) {
            $this->forget($key);
            return array("data"=>null,"expireAt">null);
        }

        $data = unserialize(substr($contents,10));

        return array("data"=>$data,"expireAt"=>$expire);
    }

    /**
     * 设置一个缓存，指定有效时间
     *
     * @param string $key
     * @param mixed $value
     * @param int $expire 有效时间，单位秒
     */
    public function put($key,$value,$expire)
    {
        $value = $this->expiration($expire).serialize($value);
        $path = $this->path($key);
        $this->write($path,$value);
    }

    /**
     * 永久缓存一个值
     *
     * @param string $key
     * @param mixed $value
     */
    public function forever($key, $value)
    {
        $this->put($key,$value,0);
    }

    /**
     * 彻底删除一个缓存
     *
     * @param string $key
     */
    public function forget($key)
    {
        $path = $this->path($key);
        if (file_exists($path)) {
            @unlink($path);
        }
    }

    /**
     * 清空所有缓存
     */
    public function flush()
    {
        $this->deleteDir($this->dir);
    }

    /**
     * 删除目录
     *
     * @param $dir
     * @return bool
     */
    protected function deleteDir($dir)
    {
        if (!is_dir($dir)) {
            return false;
        }

        $items = new \FilesystemIterator($dir);
        foreach ($items as $item) {
            if ($item->isDir()) {
                $this->deleteDir($item->getPathname());
            } else {
                @unlink($item->getPathname());
            }
        }

        return @rmdir($dir);
    }

    /**
     * 根据有效时间获取过期时间戳
     *
     * @param $seconds
     * @return int
     */
    protected function expiration($seconds)
    {
        if ($seconds==0) return 9999999999;
        return time() + $seconds;
    }

    /**
     * 根据缓存key得到缓存路径
     *
     * @param $key
     * @return string
     */
    protected function path($key)
    {
        $hash = md5($key);
        $parts = array_slice(str_split($hash, 2), 0, $this->depth);
        return $this->dir.'/'.join('/', $parts).'/'.$hash;
    }

    /**
     * 创建目录
     *
     * @param $dir
     * @return bool
     */
    protected function createDir($dir)
    {
        if (!file_exists($dir)) {
            return @mkdir($dir,0755,true);
        }
        return true;
    }

    /**
     * 写数据到文件
     *
     * @param $path
     * @param $data
     */
    protected function write($path,$data)
    {
        $this->createDir(dirname($path));
        file_put_contents($path,$data);
    }

    public function getPrefix()
    {
        return "";
    }
}