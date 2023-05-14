<?php

namespace Webguosai\Util;

use Webguosai\Helper\Arr;

class Data
{
    protected static $data = [];

    /**
     * 加载数据
     * @param array $array
     * @return void
     */
    public static function load(array $array = [])
    {
        self::$data = array_merge($array, Arr::dot($array, '.'));
    }

    /**
     * 获取数据
     * @param string $key
     * @param string $default 默认值
     * @return mixed|string
     */
    public static function get(string $key, string $default = '')
    {
        if (isset(self::$data[$key])) {
            return self::$data[$key];
        }

        return $default;
    }
}
