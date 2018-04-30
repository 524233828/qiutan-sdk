<?php
namespace Qiutan;

/**
 * Redis 助手类
 * Class RedisHelper
 * @package Helper
 */
class RedisHelper
{

    /**
     * 获取，若无数据则从getter取
     * @param $key
     * @param $redis
     * @param \Closure $getter
     * @param null $timeout 存储的时间
     * @return mixed
     */
    public static function get($key, $redis, \Closure $getter = null, $timeout = null)
    {
        $lock_key = $key . ':update:lock';

        if ($redis->exists($key)) {
            return $redis->get($key);
            // 提前20秒重新生成缓存，防止缓存雪崩
//            if ($redis->ttl($key) < 20 && !$redis->exists($lock_key) && !is_null($getter)) {
//                $redis->set($lock_key, true);
//            } else {
//                return $redis->get($key);
//            }
        }

        if ($getter !== null) {
            $result = $getter();
            if ($timeout) {
                $redis->setex($key, $timeout, $result);
            } else {
                $redis->set($key, $result);
            }

//            if ($redis->exists($lock_key)) {
//                $redis->del($lock_key);
//            }

            return $result;
        }

        return null;
    }

    public static function set($key, $value, $timeout)
    {
        $redis = redis();
        if ($timeout) {
            $redis->setex($key, $timeout, $value);
        } else {
            $redis->set($key, $value);
        }
    }

    public static function hget($key, \Closure $getter = null)
    {
        $redis = redis();
    }
}
