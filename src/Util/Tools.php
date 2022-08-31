<?php

namespace Webguosai\Util;

use Webguosai\Helper\Str;

class Tools
{
    /**
     * 是否为微信浏览器
     *
     * @return bool
     */
    public static function isWxBrowser()
    {
        return Str::contains(strtolower($_SERVER['HTTP_USER_AGENT']), strtolower('MicroMessenger'));
    }

    /**
     * 生成UUID
     *
     * @return string
     */
    public static function uuid()
    {
        $charId = md5(uniqid(mt_rand(), true));
        $hyphen = '-';
        return mb_substr($charId, 0, 8) . $hyphen
            . mb_substr($charId, 8, 4) . $hyphen
            . mb_substr($charId, 12, 4) . $hyphen
            . mb_substr($charId, 16, 4) . $hyphen
            . mb_substr($charId, 20, 12);
    }

    /**
     * 获取两坐标距离
     *
     * @param float $lng1 经度1
     * @param float $lat1 纬度1
     * @param float $lng2 经度2
     * @param float $lat2 纬度2
     * @return float 单位(米)
     */
    public static function getDistance($lng1, $lat1, $lng2, $lat2)
    {
        $radLat1 = deg2rad($lat1);
        $radLat2 = deg2rad($lat2);
        $radLng1 = deg2rad($lng1);
        $radLng2 = deg2rad($lng2);
        $a = $radLat1 - $radLat2;
        $b = $radLng1 - $radLng2;

        return 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;
    }

    /**
     * 计算某个经纬度的周围某段距离的正方形的四个点
     *
     * @param float $lng 经度
     * @param float $lat 纬度
     * @param float $distance 该点所在圆的半径，该圆与此正方形内切，默认值为0.5千米
     * @return array 正方形的四个点的经纬度坐标
     */
    public static function getSquarePoint($lng, $lat, $distance = 0.5)
    {
        // 地球半径，平均半径为6371km
        $radius = 6371;
        $d_lng =  2 * asin(sin($distance / (2 * $radius)) / cos(deg2rad($lat)));
        $d_lng = rad2deg($d_lng);
        $d_lat = $distance / $radius;
        $d_lat = rad2deg($d_lat);

        return [
            'left-top'      => ['lng' => $lng - $d_lng, 'lat' => $lat + $d_lat],
            'right-top'     => ['lng' => $lng + $d_lng, 'lat' => $lat + $d_lat],
            'left-bottom'   => ['lng' => $lng - $d_lng, 'lat' => $lat - $d_lat],
            'right-bottom'  => ['lng' => $lng + $d_lng, 'lat' => $lat - $d_lat]
        ];
    }


}
