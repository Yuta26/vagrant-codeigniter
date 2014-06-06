<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class MyMemcache
{
    private $cache;
    const SAVE_TIME = 600;
    const CACHE_CREATE = 0;

    public function __construct()
    {
        $CI =& get_instance();
        $CI->load->driver('cache', array('adapter' => 'memcached'));
        $this->cache = $CI->cache;
    }

    // $namespaceがuser_id, keyがfirst_tweetなどのkey, valueがkeyに対する値
    // $namespacekeyがversionになる

    public function loadCache($namespace, $key)
    {
        $keyName = $this->createCacheKey($namespace, $key);
        return $this->cache->get($keyName);
    }

    public function saveCache($namespace, $key, $value, $option = null)
    {
        $keyName = $this->createCacheKey($namespace, $key);
        return $this->cache->save($keyName, $value, self::SAVE_TIME);
    }

    public function deleteCache($namespace)
    {
        $namespaceValue = $this->cache->get($namespace);
        $namespaceValue++;
        return $this->cache->save($namespace, $namespaceValue, self::SAVE_TIME);
    }

    private function createCacheKey($namespace, $key)
    {
        $namespaceKey = $this->cache->get($namespace);
        if ($namespaceKey === false) {
            $namespaceKey = self::CACHE_CREATE;
            $this->cache->save($namespace ,$namespaceKey, self::SAVE_TIME);
        }
        $k = is_object($key) ? serialize($key) : $key;
        return "$namespace:$namespaceKey:$k";
    }
}