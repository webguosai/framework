<?php

namespace Webguosai\Cache;

/**
 * 静态缓存
 */
class StaticCache
{
    protected static $cacheMaps = [];

    /**
     *
     * @param mixed $id 标识
     * @param callable $callable 回调方法
     * @param string $prefix 缓存前缀
     * @return mixed
     */
    public static function get($id, callable $callable, string $prefix)
    {
        if (!isset(self::$cacheMaps[$prefix . $id])) {
            self::$cacheMaps[$prefix . $id] = $callable();
        }

        return self::$cacheMaps[$prefix . $id];
    }
}
