<?php

namespace Webguosai;

class Runtime
{
    private static function getTime()
    {
        list($usec, $sec) = explode(" ", microtime());
        return ((float)$usec + (float)$sec);
    }
    public static function start()
    {
        return self::getTime();
    }
    private static function end()
    {
        return self::getTime();
    }
    /**
     * 
     * 
     * @access     public
     * @param      int		$runtime_start	计算的开始时间
     * @param      int		$precision	         小数点位数
     * @return     string
     */
    static function show($runtime_start, $format = '', $float_num = 2)
    {
        $time_diff = self::end() - $runtime_start;
        if (!is_array($format)) {
            //$format = array('ms' => '毫秒', 's'  => '秒', 'i'  => '分', 'h'  => '小时','d'  => '天');
            $format = array(
                'ms' => 'ms ',
                's'  => 's ',
                'i'  => 'm ',
                'h'  => 'H ',
                'd'  => 'D ');
        }

        if($time_diff < 1) return '0'.$format['s'];
        $str = '';
        if($time_diff >= 3600) {
            $str .= floor($time_diff / 3600) . $format['h'];//'小时';
            $time_diff = $time_diff % 3600;
        }
        if($time_diff >= 60) {
            $str .= floor($time_diff / 60) . $format['i'];//'分钟';
            $time_diff = $time_diff % 60;
        }
        if($time_diff > 0){

            $str .= round($time_diff, $float_num) . $format['s'];//'秒';
        }
        return $str;
    }
}
