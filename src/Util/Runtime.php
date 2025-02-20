<?php

namespace Webguosai\Util;

class Runtime
{
    protected static $columns = [];

    /**
     * 开始一个标记
     *
     * @param mixed $key 标记
     */
    public static function start($key = 'key1')
    {
        static::$columns[$key] = self::getMicrosecond();
    }

    /**
     * 显示一个标记的时间
     *
     * @param mixed $key
     * @param array|null $format
     * @param int $floatNum
     * @return string
     */
    public static function show($key = 'key1', array $format = null, int $floatNum = 2): string
    {
        //$format = ['ms' => '毫秒', 's'  => '秒', 'i'  => '分', 'h'  => '小时','d'  => '天'];

        if ($format === null){
            $format = ['ms' => 'ms ', 's' => 's ', 'i' => 'm ', 'h' => 'H ', 'd' => 'D '];
        }

        $endTime      = self::getMicrosecond();
        $runtimeStart = self::$columns[$key];

        $timeDiff = $endTime - $runtimeStart;

        $str = '';
        if ($timeDiff >= 3600) {
            $str      .= floor($timeDiff / 3600) . $format['h'];//'小时';
            $timeDiff = $timeDiff % 3600;
        }
        if ($timeDiff >= 60) {
            $str      .= floor($timeDiff / 60) . $format['i'];//'分钟';
            $timeDiff = $timeDiff % 60;
        }
        if ($timeDiff > 0) {
            $str .= round($timeDiff, $floatNum) . $format['s'];//'秒';
        }
        return $str;
    }

    /**
     * 返回当前 Unix 时间戳的微秒数
     * @return float
     */
    private static function getMicrosecond()
    {
        return microtime(true);
    }

}
