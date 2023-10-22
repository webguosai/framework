<?php

namespace Webguosai\Util;

/**
 * 格式化类
 */
class Format
{
    /**
     * 保留小数点后指定位数的数字，如：3.1415926 保留两位后为：3.14(不会四舍五入)
     * @param $number
     * @param int $decimals
     * @return array|string|string[]|null
     */
    public static function reserveDecimal($number, int $decimals = 2)
    {
        return preg_replace("/(\.\d{{$decimals}})\d+/", "\\1", $number);
    }

    /**
     * 格式化数字后缀带k w e单位
     * @param mixed $number 数字
     * @param int $decimals 保留小数点位数
     * @param string[] $units 单位
     * @return string
     */
    public static function formatNumber($number, int $decimals = 1, array $units = ['k', 'w', 'e']): string
    {
        if ($number < 1000) {
            return $number;
        } elseif ($number < 10000) {
            $number = $number / 1000;
            $unit   = $units[0];
        } elseif ($number < 100000000) {
            $number = $number / 10000;
            $unit   = $units[1];
        } else {
            $number = $number / 100000000;
            $unit   = $units[2];
        }

        $number = self::reserveDecimal($number, $decimals);

        return $number . $unit;
    }

    /**
     * 格式化金额
     * 6000 = 6,000.00
     *
     * @param int $money 金额
     * @param int $decimals 小数点位数
     * @return string
     */
    public static function formatMoney(int $money = 0, int $decimals = 2): string
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
    public static function formatMoneyCurrency(int $money = 0, int $decimals = 2, string $symbol = '￥', string $position = 'left'): string
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
    public static function money2capital(int $money = 0): string
    {
        return (new \Capital\Money($money))->toCapital();
    }

    /**
     * 手机号码脱敏
     * @param string $mobile
     * @param string $padString
     * @return string
     */
    public static function formatMobile(string $mobile, string $padString = '*'): string
    {
        return substr($mobile, 0, 3) . str_pad('', 4, $padString) . substr($mobile, -4);
    }
}
