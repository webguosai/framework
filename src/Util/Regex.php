<?php

namespace Webguosai\Util;

class Regex
{
    public static function isUrl($value)
    {
        return self::filter($value, FILTER_VALIDATE_URL);
    }

    public static function isEmail($value)
    {
        return self::filter($value, FILTER_VALIDATE_EMAIL);
    }

    public static function isMobile($value)
    {
        return (bool)preg_match('/^1[3456789]\d{9}$/', $value);
    }

    public static function filter($value, $filter)
    {
        return false !== filter_var($value, $filter);
    }
}
