<?php

namespace Webguosai\Helper;

class Helper
{
    /**
     * 计算两日期相差天数
     * @param string $endTime 结束时间
     * @param string $startTime 开始时间
     * @param int $flag 传入日期格式(0-时间戳,1-日期格式)
     * @return false|float
     */
    public static function computeDiffDay($endTime = '', $startTime = '', $flag = 1)
    {
        //转换为天，取出时分秒
        $startTime = ($startTime == '') ? date('Y-m-d H:i:s', time()) : $startTime;
        $endTime   = ($endTime == '') ? date('Y-m-d H:i:s', time()) : $endTime;
        if ($flag) {
            $startTime = strtotime($startTime);
            $endTime   = strtotime($endTime);
        }
        $startTime = floor($startTime / 86400);
        $endTime   = floor($endTime / 86400);
        return $endTime - $startTime;
    }

    /**
     * 返回可读性更好的文件尺寸
     * @param string $bytes 原字符串
     * @param int $decimals 保留长度
     * @return string
     */
    public static function formatFileSize(string $bytes, $decimals = 2)
    {
        $size   = ['B', 'kB', 'MB', 'GB', 'TB', 'PB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
    }

    /**
     * 格式化金额
     * 6000 = 6,000.00
     *
     * @param int $money 金额
     * @param int $decimals 小数点位数
     * @return string
     */
    public static function formatMoney($money = 0, $decimals = 2)
    {
        return number_format((float)$money, $decimals);
    }

    /**
     * 金额带货币
     * 6000 = ￥6,000.00
     *
     * @param int $money
     * @param int $decimals 小数点位数
     * @param string $symbol 货币符号
     * @param string $position 货币符号显示位置(默认为左边)
     * @return string
     */
    public static function formatMoneyCurrency($money = 0, $decimals = 2, $symbol = '￥', $position = 'left')
    {
        if ($position === 'right') {
            return static::formatMoney($money, $decimals) . $symbol;
        }
        return $symbol . static::formatMoney($money, $decimals);
    }

    /**
     * 金额转中文大写
     * 6000 = 陆仟元
     *
     * @param int $money
     * @return string
     */
    public static function money2capital($money = 0)
    {
        return (new \Capital\Money($money))->toCapital();
    }
}
