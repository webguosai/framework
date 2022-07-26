<?php

namespace Webguosai\Util;

use Carbon\Carbon;
use Webguosai\Helper\Str;

class Date
{
    /**
     * 获取时间内容
     * @param $range
     * @param string $mode 当range为空时的模式，today为获取当天
     * @return string[]
     */
    public static function getRangeDateTime($range, string $mode = '')
    {
        if (is_string($range)) {
            $range = explode(' - ', $range);
        }

        // 无值则为当天
        if (empty($range) || count($range) !== 2 || empty($range[0]) || empty($range[1])) {
            if ($mode == 'today') {
                $range = [
                    date('Y-m-d'),
                    date('Y-m-d'),
                ];
            } else {
                return [];
            }
        }

        if (!Str::contains($range[0], ':')) {
            $range[0] .= ' 00:00:00';
        }
        if (!Str::contains($range[1], ':')) {
            $range[1] .= ' 23:59:59';
        }

        $startDateTime = date('Y-m-d H:i:s', strtotime($range[0]));
        $endDateTime   = date('Y-m-d H:i:s', strtotime($range[1]));

        return [$startDateTime, $endDateTime];
    }

    /**
     * 获取24小时段
     * @return array
     */
    public static function getTimeSub()
    {
        $ret = [];
        for ($i = 0; $i < 24; $i++) {
            $ret[] = [
                'name' => "{$i}点",
                'range' => [
                    str_pad($i, 2, '0', STR_PAD_LEFT).":00:00",
                    str_pad($i, 2, '0', STR_PAD_LEFT).":59:59",
                ]
            ];
        }
        return $ret;
    }
    /**
     * 获取时间分段
     *
     * @param array $rangeDateTime
     * @return array
     */
    public static function getDateSub(array $rangeDateTime)
    {
        $startDate = $rangeDateTime[0];
        $endDate   = $rangeDateTime[1];

        $start = Carbon::parse($startDate);
        $end   = Carbon::parse($endDate);

        $ret = [];
        if (($diff = $start->diffInYears($end)) !== 0) {
            //年
            for ($i = 0; $i <= $diff; $i++) {
                $ret[] = [
                    'name' => Carbon::parse($startDate)->addYears($i)->format('Y'),
                    'range' => [
                        Carbon::parse($startDate)->addYears($i)->toDateTimeString(),
                        Carbon::parse($startDate)->addYears($i+1)->subSecond(1)->toDateTimeString(),
                    ]
                ];
            }
        } elseif (($diff = $start->diffInMonths($end)) !== 0) {
            //月
            for ($i = 0; $i <= $diff; $i++) {
                $ret[] = [
                    'name' => Carbon::parse($startDate)->addMonths($i)->format('Y-m'),
                    'range' => [
                        Carbon::parse($startDate)->addMonths($i)->toDateTimeString(),
                        Carbon::parse($startDate)->addMonths($i+1)->subSecond(1)->toDateTimeString(),
                    ]
                ];
            }
        } else {
            $diff = $start->diffInDays($end);

            if ($diff === 0) {
                //几小时
                $diff = $start->diffInHours($end);

                for ($i = 0; $i <= $diff; $i++) {
                    $ret[] = [
                        'name' => "{$i} 点",
                        'range' => [
                            Carbon::parse($startDate)->addHours($i)->toDateTimeString(),
                            Carbon::parse($startDate)->addHours($i+1)->subSecond(1)->toDateTimeString(),
                        ]
                    ];
                }

            } else {
                // 几天
                for ($i = 0; $i <= $diff; $i++) {
                    $ret[] = [
                        'name' => Carbon::parse($startDate)->addDays($i)->format('Y-m-d'),
                        'range' => [
                            Carbon::parse($startDate)->addDays($i)->toDateTimeString(),
                            Carbon::parse($startDate)->addDays($i+1)->subSecond(1)->toDateTimeString(),
                        ]
                    ];
                }
            }

        }
        return $ret;

    }

    /**
     * 获取分段器中起始和结束时间
     *
     * @param array $subs
     * @return array
     */
    public static function getSubRange(array $subs)
    {
        $dates = [];
        foreach ($subs as $info){
            $dates[] = $info['range'][0];
            $dates[] = $info['range'][1];
        }

        sort($dates);

        return [
            current($dates),
            end($dates)
        ];
    }

    /**
     * 将指定日期时间按格式显示
     *
     * @param string $dateValue 日期或时间 (2022-12-01 15:00:00)
     * @param string $dateFormat 日期部分格式 (Y/m/d)
     * @param string $timeFormat 时间部分格式 (H:i:s)
     * @return false|string
     */
    public static function formatShow($dateValue, $dateFormat = 'Y-m-d', $timeFormat = 'H:i:s')
    {
        if (self::isDateString($dateValue)) {
            // 转成时间戳
            $time = strtotime($dateValue);
            $format = $dateFormat . ' ' . $timeFormat;

            // 根据内容，来判断用哪种方式显示
            if (Carbon::hasFormat($dateValue, 'Y-m-d H:i:s')) {
                // 日期和时间
                return date($format, $time);
            } elseif (Carbon::hasFormat($dateValue, 'Y-m-d')) {
                // 日期
                return date($dateFormat, $time);
            } elseif (Carbon::hasFormat($dateValue, 'H:i:s')) {
                // 时间
                return date($timeFormat, $time);
            }
        }

        return $dateValue;
    }

    /**
     * 是否为日期字符串
     *
     * @param $date
     * @return bool
     */
    public static function isDateString($date)
    {
        if (!$date || $date == "NULL" || is_null($date) || $date == "0000-00-00") {
            return false;
        } else {
            return true;
        }
    }
}
