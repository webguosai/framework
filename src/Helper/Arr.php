<?php

namespace Webguosai\Helper;

class Arr
{
    /**
     * 得到一个数组的md5值
     *
     * @param array $array
     * @return string
     */
    public static function md5(array $array = [])
    {
        return md5(json_encode($array));
    }

    /**
     * 数组版stripos
     * Arr::stripos('中华人民共和国', ['人民']);
     *
     * @param string $string
     * @param array $array
     * @return bool
     */
    public static function stripos(string $string, array $array = [])
    {
        foreach ($array AS $value) {
            if (stripos($string, $value) !== false) {
                return true;
            }
        }
        return false;
    }

//    public static function find(string $string, array $array = [])
//    {
//        foreach ($array as $value) {
//
//        }
//    }

    /**
     * 将数组的key名转换为小驼峰 (user_info => userInfo)
     *
     * @param array $array
     * @return mixed
     */
    public static function studly(array $array = [])
    {
        if (!is_array($array) || empty($array)) {
            return $array;
        }

        $json = json_encode($array);

        $rex  = '#[,{]+"([^"]+)":#i';
        $json = preg_replace_callback($rex, function ($mat) {
            return Str::studly($mat[0]);
        }, $json);

        return json_decode($json, true);
    }
    public static function isLast($array, $value)
    {
        return $value == end($array);
    }
}