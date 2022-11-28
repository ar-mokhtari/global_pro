<?php

namespace app\modules\Codnitive\Core\helpers;

// use Yii;

class Cache
{

    public static function getCacheKey($data): string
    {
        if (is_array($data)) {
            $data = serialize($data);
        }
        return app()->cache->buildKey($data);
        // return sprintf('%u',crc32($data));
    }

    public static function getCacheData($key)
    {
        if ((bool) app()->params['cache']['flush']) {
            app()->cache->flush();
        }
        // $cache = app()->cache;
        if ((bool) app()->params['cache']['enable']) {
            return app()->cache->get($key);
        }
        return false;
    }

    // public static function setCacheData($key, $value, $duration = 60 * 60 * 24)
    public static function setCacheData($key, $value, $duration = 60 * 90)
    {
        if ((bool) app()->params['cache']['flush']) {
            app()->cache->flush();
        }
        // $cache = app()->cache;
        if ((bool) app()->params['cache']['enable']) {
            return app()->cache->set($key, $value, $duration);
        }
        return false;
    }

    public static function getOrSetCacheData($key, $value, $duration = 60 * 90)
    {
        return app()->cache->getOrSet(
            $key, 
            function () use ($value) {
                return $value;
            }, 
            $duration
        );
    }
}
