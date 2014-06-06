<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class MyMemcache
{
    private $cache;

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
        return $this->cache->save($keyName, $value, 360);
    }

    public function deleteCache($namespace)
    {
        $namespaceValue = $this->cache->get($namespace);
        $namespaceValue++;
        return $this->cache->save($namespace, $namespaceValue, 300 );
    }

    private function createCacheKey($namespace, $key)
    {
        $namespaceKey = $this->cache->get($namespace);
        if ($namespaceKey === false) {
            $namespaceKey = 0;
            $this->cache->save($namespace ,$namespaceKey, 300);
        }
        $k = is_object($key) ? serialize($key) : $key;
        return "$namespace:$namespaceKey:$k";
    }
}