<?php

namespace Webguosai\Util;

use Webguosai\Helper\Str;

class Url
{
    /**
     * 是否为url
     *
     * @param $url
     * @return bool
     */
    public static function isUrl($url)
    {
        return Regex::isUrl($url);
    }

    /**
     * 获取后缀名
     *
     * @param string $string
     * @return string
     */
    public static function getExtension($string)
    {
        if (Str::contains($string, '.')) {
            return substr(strrchr($string, '.'), 1);
        }

        return '';
    }

    /**
     * 获取文件名(不含后缀)
     *
     * @param string $url
     * @return mixed|string
     */
    public static function getFileName($url)
    {
        return pathinfo($url, PATHINFO_FILENAME);
    }

    /**
     * 获取文件名加后缀
     *
     * @param string $url
     * @return mixed|string
     */
    public static function getBaseName($url)
    {
        return pathinfo($url, PATHINFO_BASENAME);
    }

}
