<?php

namespace Webguosai\Util;

use Webguosai\Helper\Arr;

class Data
{
    // 原始数据
    protected static $rawData = [];
    // 平铺后的数据
    protected static $dotData = [];

    /**
     * 加载数据
     * @param array $array
     * @return void
     */
    public static function load(array $array = [])
    {
        self::$rawData = $array;
        self::$dotData = array_merge($array, Arr::dot($array, '.'));
    }

    /**
     * 获取数据
     * @param string $keyName
     * @param mixed $default 默认值
     * @return mixed|string
     */
    public static function get(string $keyName, $default = '')
    {
        if (isset(self::$dotData[$keyName])) {
            return self::$dotData[$keyName];
        }

        return $default;
    }

    /**
     * 获取id (0或空返回默认值)
     * @param string $keyName
     * @param mixed $default
     * @return int|mixed|string
     */
    public static function getId(string $keyName, $default = '')
    {
        $number = (int)self::get($keyName, $default);

        if (empty($number)) {
            return $default;
        }

        return $number;
    }

    /**
     * 获取ids
     * @param string $keyName
     * @param string $valueName
     * @param mixed $default 默认值
     * @return array|mixed 如果是正确返回则是一个数组
     */
    public static function getIds(string $keyName, string $valueName = 'id', $default = [])
    {
        if (!isset(self::$rawData[$keyName]) || empty(self::$rawData[$keyName])) {
            return $default;
        }

        return array_map(function ($value) use ($valueName) {
            return $value[$valueName];
        }, self::$rawData[$keyName]);
    }
}
