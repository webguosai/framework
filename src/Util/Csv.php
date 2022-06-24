<?php

/**
 * csv操作
 * 演示：

    $content = <<<EOF
张三\t男\t18岁
李四\t女\t19岁
王五\t未知\t20岁
    EOF;

    $sql = Csv::toInsertSql($content, 'student');
    var_dump($sql);
 */
namespace Webguosai\Util;

class Csv
{
    /**
     * csv数据转换为php数组
     *
     * @param string $content csv内容
     * @param bool $isTitle 是否有标题
     * @return false|string[]
     */
    public static function toArray($content, $isTitle = false)
    {
        $arr = explode("\n", $content);

        // 有标题删除第一行
        if ($isTitle) {
            unset($arr[0]);
        }

        $arr = array_map(function ($value) {
            $line = trim($value); // 前后空格处理
            if ($line) {
                return explode("\t", $line);
            }
            return null;
        }, $arr);

        // 去空，重新排序key
        return array_values(array_filter($arr));
    }

    /**
     * 转换为sql插入语句
     *
     * @param string $csvContent csv内容
     * @param string $table 表名
     * @param string $wrapPrefix 前缀
     * @return string
     */
    public static function toInsertSql($csvContent, $table, $wrapPrefix = 'NULL, ')
    {
        $sql = '';

        $list = self::toArray($csvContent);

        foreach ($list  as $item) {
            $arr = array_map(function ($value) use ($table) {
                return "'{$value}'";
            }, $item);
            $wrap = implode(', ', $arr);

            $sql .= "INSERT INTO {$table} VALUES ({$wrapPrefix}{$wrap});\n";
        }

        return $sql;
    }
}