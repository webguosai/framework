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
        if (!empty($prefix)) {
            $prefix = $prefix . '.';
        }
        $key = $prefix . $id;

        if (!isset(self::$cacheMaps[$key])) {
            self::$cacheMaps[$key] = $callable();
        }

        return self::$cacheMaps[$key];
    }

    /**
     * 清空缓存
     * @return void
     */
    public static function clear()
    {
        self::$cacheMaps = [];
    }
}
