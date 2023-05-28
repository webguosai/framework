<?php

namespace Webguosai\Util;

use ReflectionClass;
use ReflectionException;
use Webguosai\Helper\Arr;

class Enum
{
    /**
     * 默认值
     * @var null
     */
    public static $default = null;

    /**
     * map
     * @var array|null
     */
    public static $maps = null;

    /**
     * 实例
     * @var array
     */
    public static $instances = [];

    /**
     * 返回所有枚举的值
     *
     * @return mixed
     */
    public static function values()
    {
        $maps = static::maps();
        return array_keys($maps);
    }

    /**
     * 映射的对应值
     *
     * @return array
     */
    public static function maps()
    {
        if (is_null(static::$maps)) {
            return self::fromConstants();
        }

        return static::$maps;
    }

    /**
     * 获取注释
     *
     * @return string
     */
    public static function comment()
    {
        $maps = self::maps();

        $temp = [];
        foreach ($maps as $key => $map) {
            if ($key == $map) {
                $temp[] = $map;
            } else {
                $temp[] = $key.'='.$map;
            }
        }

        return '(' . implode(', ', $temp) . ')';
    }

    /**
     * 转换为options
     *
     * @param string $labelKeyName
     * @param string $valueKeyName
     * @return array
     */
    public static function toOptions(string $labelKeyName = 'label', string $valueKeyName = 'value')
    {
        $maps = static::maps();
        $options = [];
        foreach ($maps as $key => $value) {
            $options[] = [
                $labelKeyName => $value,
                $valueKeyName => $key,
            ];
        }
        return $options;
    }

    /**
     * 从映射中获取指定key的value值
     *
     * @param string|mixed $findKey 要查找的key值
     * @return mixed
     */
    public static function getMapValue($findKey)
    {
        return self::maps()[$findKey];
    }

    /**
     * 从映射中获取指定value的key值
     *
     * @param string|mixed $findValue 要查找的value值
     * @return mixed
     */
    public static function getMapKey($findValue)
    {
        $maps = self::maps();

        foreach ($maps as $key => $value) {
            if ($value == $findValue) {
                return $key;
            }
        }

        return '';
    }

    /**
     * 枚举是否在内容范围内
     *
     * @param string|array $text
     * @return bool
     */
    public static function in($text)
    {
        return Arr::in($text, static::values());
    }

    /**
     * 获取默认枚举
     *
     * @return null|string
     */
    public static function getDefault()
    {
        return static::$default;
    }

    /**
     * 从常量中获取
     *
     * @return mixed
     */
    protected static function fromConstants()
    {
        $class = get_called_class();

        // 从已缓存的实例中获取
        if (isset(self::$instances[$class])) {
            return self::$instances[$class];
        }

        try {
            $constants = (new ReflectionClass(get_called_class()))->getConstants();
        } catch (ReflectionException $e) {
            $constants = [];
        }

        self::$instances[$class] = array_combine(array_values($constants), $constants);

        return self::$instances[$class];
    }
}
