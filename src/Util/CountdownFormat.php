<?php

namespace Webguosai\Util;

class CountdownFormat
{
    const zh_cn = 1; //简体中文单位下标
    const zh_tw = 2; //繁体中文单位下标
    const en_us = 3; //英文单位下标

    //内置时间单位
    const unit = array(
        1 => array(
            'd' => '天',
            'h' => '时',
            'm' => '分',
            's' => '秒'
        ),
        2 => array(
            'd' => '天',
            'h' => '時',
            'm' => '分',
            's' => '秒'
        ),
        3 => array(
            'd' => 'd',
            'h' => 'h',
            'm' => 'm',
            's' => 's'
        ),
    );

    const min_primary_seconds = 0;
    const max_primary_seconds = PHP_INT_MAX;
    const default_format = 'dhms';//默认格式化格式

    const seconds_of_day = 60 * 60 * 24;
    const seconds_of_hour = 60 * 60;
    const seconds_of_minutes = 60;

    private $_format; //格式化格式 e.g. dhms => d天h时m分s秒
    private $_enable_unit;//当前启用的单位

    private $_rest_seconds;//剩余秒数

    private $_day_format;//格式化后的 天
    private $_hour_format;//格式化后的 时
    private $_minutes_format;//格式化后的 分
    private $_seconds_format;//格式化后的 秒

    /**
     * countdownFormat constructor.
     * @param $primary_seconds
     * @param string $format 格式化格式
     * @param int|array $unit 时间单位
     */
    public function __construct($primary_seconds, $format = self::default_format, $unit=self::zh_cn)
    {
        $this->initPrimarySeconds($primary_seconds);
        $this->initFormat($format);
        $this->initUnit($unit);
    }

    public static function getFormat($primary_seconds,$format=self::default_format,$unit=self::zh_cn){
        $countdown_format = new CountdownFormat($primary_seconds,$format,$unit);
        return $countdown_format->format();
    }

    /**
     * 初始化未格式化秒数
     * @param $primary_seconds
     */
    private function initPrimarySeconds($primary_seconds){
        if (self::min_primary_seconds <= $primary_seconds && $primary_seconds <= self::max_primary_seconds){
            $this->_rest_seconds = $primary_seconds;
        }else{
            $this->_rest_seconds = 0;//不在范围内返回0
        }
    }

    private function initFormat($format){
        if ($format){
            $format_arr = array();
            $format = substr($format,0,4);//只取前4位
            for ($i = 0; $i < strlen($format); $i++){
                $format_arr[] = $format[$i];
            }
            $format_arr_uniue = array_unique($format_arr);//去重 ddd => d
            sort($format_arr_uniue,SORT_STRING);//排序 smhd => dhms
            $this->_format = implode('',$format_arr_uniue);
        }else{
            $this->_format = self::default_format;
        }
    }

    private function initUnit($unit){
        if ($unit) {
            if (is_array($unit)) {
                $this->_enable_unit = array_merge(self::unit[self::zh_cn], $unit);
            }elseif(in_array(intval($unit),array_keys(self::unit))){
                $this->_enable_unit = self::unit[$unit];
            }
        }
        if (!$this->_enable_unit) self::unit[self::zh_cn];
    }

    public function format()
    {
        switch ($this->_format) {
            case 'dhms':
                $ret = $this->formatDay()->formatHour()->formatMinutes()->formatSeconds()->getResult();
                break;
            case 'dhm':
                $ret = $this->formatDay()->formatHour()->formatMinutes()->getResult();
                break;
            case 'hms':
                $ret = $this->formatHour()->formatMinutes()->formatSeconds()->getResult();
                break;
            case 'dh':
                $ret = $this->formatDay()->formatHour()->getResult();
                break;
            case 'hm':
                $ret = $this->formatHour()->formatMinutes()->getResult();
                break;
            case 'ms':
                $ret = $this->formatMinutes()->formatSeconds()->getResult();
                break;
            case 'd':
                $ret = $this->formatDay()->getResult();
                break;
            case 'h':
                $ret = $this->formatHour()->getResult();
                break;
            case 'm':
                $ret = $this->formatMinutes()->getResult();
                break;
            default:
                $ret = $this->formatDay()->formatHour()->formatMinutes()->formatSeconds()->getResult();
        }
        return $ret;
    }

    /**
     * 返回对应格式化位数的值
     * 如果首位为0则不返回对应的值
     * dhms => 1天1时1分1秒
     *      => 1时1分1秒
     *      => 1分1秒
     *      => 1秒
     *      => 1天0时1分1秒
     *      => 1天0时0分1秒
     *      => 1天0时0分0秒
     * @return string
     */
    private function getResult()
    {
        $result = '';
        for ($i = 0; $i < strlen($this->_format); $i++) {
            switch ($this->_format[$i]) {
                case 'd':
                    if ($this->_day_format) {
                        $result .= $this->_day_format;
                    }
                    break;
                case 'h':
                    if ($this->_hour_format) {
                        $result .= $this->_hour_format;
                    } else {
                        if ($this->_day_format){
                            $result .= '0' . $this->_enable_unit['h'];
                        }else{
                            $result .= $this->_hour_format;
                        }
                    }
                    break;
                case 'm':
                    if ($this->_minutes_format) {
                        $result .= $this->_minutes_format;
                    } else {
                        if ($this->_hour_format){
                            $result .= '0' . $this->_enable_unit['m'];
                        }else{
                            $result .= $this->_minutes_format;
                        }
                    }
                    break;
                case 's':
                    if ($this->_seconds_format) {
                        $result .= $this->_seconds_format;
                    } else {
                        if ($this->_minutes_format){
                            $result .= '0' . $this->_enable_unit['s'];
                        }else{
                            $result .= $this->_seconds_format;
                        }
                    }
                    break;
            }
        }
        return $result;
    }

    private function formatDay()
    {
        $day = floor($this->_rest_seconds / self::seconds_of_day);
        $this->_rest_seconds = $this->_rest_seconds - $day * self::seconds_of_day;
        if ($day) {
            $this->_day_format = $day . $this->_enable_unit['d'];
        }
        return $this;
    }

    private function formatHour()
    {
        $hour = floor($this->_rest_seconds / self::seconds_of_hour);
        $this->_rest_seconds = $this->_rest_seconds - $hour * self::seconds_of_hour;
        if ($hour) $this->_hour_format = $hour . $this->_enable_unit['h'];
        return $this;
    }

    private function formatMinutes()
    {
        $minutes = floor($this->_rest_seconds / self::seconds_of_minutes);
        $this->_rest_seconds = $this->_rest_seconds - $minutes * self::seconds_of_minutes;
        if ($minutes) $this->_minutes_format = $minutes . $this->_enable_unit['m'];
        return $this;
    }

    private function formatSeconds()
    {
        if ($this->_rest_seconds) $this->_seconds_format = $this->_rest_seconds . $this->_enable_unit['s'];
        return $this;
    }
}
