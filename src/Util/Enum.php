<?php

namespace Webguosai\Util;

use ReflectionClass;
use ReflectionException;
use Webguosai\Helper\Arr;
use Exception;

class Enum
{
    /**
     * @var null
     */
    public static $default = null;

    /**
     * 获取所有枚举常量
     * @return mixed
     */
    public static function all()
    {
        $constants = [];
        try {
            $class = new ReflectionClass(get_called_class());
            $constants = $class->getConstants();
        } catch (ReflectionException $e) {

        }

        return array_values($constants);
    }

    /**
     * 枚举是否在内容范围内
     *
     * @param string|array $text
     * @return bool
     */
    public static function in($text) {
        return Arr::in($text, self::all());
    }

    /**
     * 设置默认值
     *
     * @param $default
     * @throws Exception
     */
//    public static function setDefault($default) {
//
//        if (!Arr::in($default, self::all())) {
//            throw new Exception('不在指定范围内');
//        }
//
//        static::$default = $default;
//    }

    /**
     * 获取默认枚举
     *
     * @return null
     */
    public static function getDefault() {
        return static::$default;
    }
}
