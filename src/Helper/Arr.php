<?php

namespace Webguosai\Helper;

class Arr
{
    /**
     * 得到一个数组的md5值
     *
     * @param array $array
     * @param array|string $onlyKeys
     * @return string
     */
    public static function md5(array $array = [], $onlyKeys = [])
    {
        if ($onlyKeys) {
            $array = static::only($array, $onlyKeys);
        }

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

    /**
     * @param array $array
     * @param array|string $keys
     * @return array
     */
    public static function only(array $array, $keys)
    {
        return array_intersect_key($array, array_flip((array) $keys));
    }

    /**
     * 数组中某个key的value值是否包含指定内容，并返回相应内容
     * Arr::containsKey('张三', 'name', [[ 'id'   => 1, 'name' => '张三', 'desc' => 'zs'], [ 'id'   => 2, 'name' => '李四', 'desc' => 'ls']], 'desc');
     *
     * @param string $string 要查找的内容
     * @param string $searchKeyName 要查找的key名
     * @param array $array 要查找的数组
     * @param string $retKeyName 返回的key名
     * @return mixed|null
     */
    public static function containsKey(string $string, string $searchKeyName, array $array = [], $retKeyName = '')
    {
        foreach ($array as $value) {
            if (Str::contains($value[$searchKeyName], $string) !== false) {
                if ($retKeyName) {// && isset($value[$retKeyName])
                    return $value[$retKeyName];
                } else {
                    return $value;
                }
            }
        }

        return null;
    }

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