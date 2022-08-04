<?php

namespace Webguosai\Util;

/**
 * 仿javascript的charCodeAt
 *
 * CharCodeAt::toString('Hi')
 * CharCodeAt::toArray('Hi')
 * CharCodeAt::toNumber('H')
 */
class CharCodeAt
{
    /**
     * 内容合并
     *
     * @param string $string
     * @param string $encoding 编码
     * @return string
     */
    public static function toString($string, $encoding = 'UTF-8')
    {
        return implode(self::toArray($string, $encoding));
    }

    /**
     * 数组
     *
     * @param string $string 内容
     * @param string $encoding 编码
     * @return array
     */
    public static function toArray($string, $encoding = 'UTF-8')
    {
        $arr = [];
        for ($i = 0; $i < mb_strlen($string, $encoding); $i++) {
            $arr[] = self::toNumber(mb_substr($string, $i, 1, $encoding));
        }
        return $arr;
    }

    /**
     * 将单个字符转换为数字
     * 参照：https://github.com/voku/portable-utf8
     * chr_to_decimal()
     *
     * @param string $char 单个字符
     * @param string $encoding 编码
     * @return mixed
     */
    public static function toNumber($char, $encoding = 'UTF-8')
    {
        $chr_tmp = iconv($encoding, 'UCS-4LE', $char);

        return unpack('V', $chr_tmp)[1];
    }
}
