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
     * @param mixed $array
     * @return bool
     */
    public static function stripos($string, $array = [])
    {
        if (is_array($array) && !empty($string)) {
            foreach ($array as $value) {
                if (stripos($string, $value) !== false) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * 只要指定的字段
     *
     * @param array $array
     * @param array|string $keys
     * @return array
     */
    public static function only(array $array, $keys)
    {
        return array_intersect_key($array, array_flip((array)$keys));
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

    /**
     * 是否为最后一个
     *
     * @param array $array 数组
     * @param mixed $value
     * @return bool
     */
    public static function isLast(array $array, $value)
    {
        return $value == end($array);
    }

    /**
     * 合并数组
     *
     * @param array $default
     * @param array $options
     * @return array
     */
    public static function merge(array $default, array $options)
    {
        return \Graze\ArrayMerger\RecursiveArrayMerger::lastNonNull($default, $options);
    }

    /**
     * 返回输入数组中某个单一列的值
     *
     * @param array $array
     * @param string $column
     * @param null $index_key
     * @return array
     */
    public static function column(array $array, $column, $index_key = null)
    {
        return array_column($array, $column, $index_key);
    }

    /**
     * 在数组中查询是否存在
     *
     * @param string|array $text 要查找的(支持数组和字符串)
     * @param array $array 支持 * 通配
     * @return bool
     */
    public static function in($text, array $array)
    {
        if (empty($text)) {
            return false;
        }

        $textArr = is_array($text) ? $text : [$text];

        foreach ($textArr as $value) {
            foreach ($array as $value2) {
                if ($value == $value2) {
                    return true;
                }

                // 支持 * 通配符
                if (Str::is($value2, $value)) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * 获取一个数组中的随机数
     *
     * @param array $array
     * @return mixed
     */
    public static function random(array $array)
    {
        return $array[array_rand($array)];
    }

    /**
     * 增强原生 array_map 支持key
     *
     * @param callable $callable 回调函数
     * @param array $array 数组
     * @return array
     */
    public static function map(callable $callable, array $array)
    {
        $map = [];

        foreach ($array as $key => $value) {
            $result = $callable($key, $value);

            if (is_array($result)) {
                $map[key($result)] = $result[key($result)];
            } elseif (is_string($result)) {
                $map[$key] = $result;
            } else {
                $map[$key] = $value;
            }
        }

        return $map;
    }

    /**
     * 数组连接为字符
     *
     * @param array $array 数组
     * @param string $symbol 连接符号
     * @return string
     */
    public static function implode($array, $symbol = ',')
    {
        return implode($symbol, $array);
    }

    /**
     * 数组去空、去重、并重新排列key
     *
     * @param array $array
     * @param bool $allowZero 允许0
     * @return array
     */
    public static function filterUnique($array, $allowZero = false)
    {
        if ($allowZero) {
            return array_values(array_filter(array_unique($array), function ($item) {
                return $item !== '' && $item !== null && $item !== false;
            }));
        }

        return array_values(array_filter(array_unique($array)));
    }

    /**
     * 合并两个数组的关联内容，减少N+1和sql查询
     *
     * @param array $mainList 主要的数组
     * @param array $fromList 从数组
     * @param string $addKey 添加的key名
     * @param string $findKey 查找关联的key名
     * @param string $idKey 主键id名
     * @return array
     */
    public static function mergeRelation($mainList, $fromList, $addKey, $findKey, $idKey = 'id')
    {
        foreach ($mainList as $key => $value) {
            $data = [];
            if (!empty($fromList)) {
                $find = Arr::containsKey($value[$idKey], $findKey, $fromList);
                if (!is_null($find)) {
                    $data = $find;
                }
            }

            $mainList[$key][$addKey] = $data;
        }

        return $mainList;
    }

    /**
     * 判断从数组中的关联数据是否在主数组中，减少N+1和sql查询
     *
     * @param array $mainList 主要的数组
     * @param array $fromList 从数组
     * @param string $addKey 添加的key名
     * @param string $findKey 查找关联的key名
     * @param string $idKey 主键id名
     * @return array
     */
    public static function mergeRelationIs($mainList, $fromList, $addKey, $findKey, $idKey = 'id')
    {
        foreach ($mainList as $key => $value) {
            $data = false;
            if (!empty($fromList)) {
                $data = null !== Arr::containsKey($value[$idKey], $findKey, $fromList);
            }

            $mainList[$key][$addKey] = $data;
        }

        return $mainList;
    }

    /**
     * 平铺数组
     * @param array $array
     * @param string $link 连接符号
     * @param string $prepend
     * @return array
     */
    public static function dot($array, $link = '.', $prepend = '')
    {
        $results = [];

        foreach ($array as $key => $value) {
            if (is_array($value) && !empty($value)) {
                $results = array_merge($results, static::dot($value, $link, $prepend . $key . $link));
            } else {
                $results[$prepend . $key] = $value;
            }
        }

        return $results;
    }

    /**
     * 数组转换为表单的label、value格式
     * @param $array
     * @param string $labelKeyName
     * @param string $valueKeyName
     * @param string $labelName
     * @param string $valueName
     * @return array
     */
    public static function options($array, string $labelKeyName = 'name', string $valueKeyName = 'id', string $labelName = 'label', string $valueName = 'value')
    {
        $options = [];
        foreach ($array as $key => $value) {
//            if (is_array($value)) {
                $options[] = [
                    $labelName => $value[$labelKeyName],
                    $valueName => $value[$valueKeyName],
                ];
//            } else {
//                $options[] = [
//                    $labelName => $value,
//                    $valueName => $key,
//                ];
//            }

        }
        return $options;
    }
}
