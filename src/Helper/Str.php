<?php

namespace Webguosai\Helper;

class Str
{
    /**
     * 下划线转驼峰
     *
     * @param string $string
     * @param string $separator
     * @return string
     */
    public static function hump(string $string, $separator = '_')
    {
        $string = $separator . str_replace($separator, " ", strtolower($string));
        return ltrim(str_replace(" ", "", ucwords($string)), $separator);
    }

    /**
     * 模板替换
     * Str::templateReplace('你好：{nickname}', ['nickname' => '张三'], true)
     *
     * @param string $string 模板内容
     * @param array $array 数组
     * @param bool $clearEmptyLabel 清除无用标签
     * @param string $leftLabel 左标签符号
     * @param string $rightLabel 右标签符号
     * @return string
     */
    public static function templateReplace(string $string, array $array, $clearEmptyLabel = false, $leftLabel = '{', $rightLabel = '}')
    {
        $search  = [];
        $replace = [];
        foreach ($array as $key => $value) {
            if (!is_array($value)) {
                $search[]  = $leftLabel . $key . $rightLabel;
                $replace[] = $value;
            }
        }

        $content = str_ireplace($search, $replace, $string);

        if ($clearEmptyLabel) {
            $content = preg_replace("/{$leftLabel}[^{$rightLabel}]*{$rightLabel}/i", '', $content);
        }

        return $content;
    }

}
