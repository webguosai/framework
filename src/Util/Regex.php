<?php

namespace Webguosai\Util;

class Regex
{
    /**
     * 是否为链接格式
     * @param $value
     * @return bool
     */
    public static function isUrl($value)
    {
        return self::filter($value, FILTER_VALIDATE_URL);
    }

    /**
     * 是否为邮箱格式
     * @param $value
     * @return bool
     */
    public static function isEmail($value)
    {
        return self::filter($value, FILTER_VALIDATE_EMAIL);
    }

    /**
     * 是否为手机号码格式
     * @param $value
     * @return bool
     */
    public static function isMobile($value)
    {
        return (bool)preg_match('/^1[3456789]\d{9}$/', $value);
    }

    /**
     * 是否为中文
     * @param $value
     * @return bool
     */
    public static function isChina($value)
    {
        $pattern = '/[\x{4e00}-\x{9fa5}]+/u';
        return (bool)preg_match($pattern, $value);
    }

    public static function filter($value, $filter)
    {
        return false !== filter_var($value, $filter);
    }
}
