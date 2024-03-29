<?php

namespace Webguosai\Util;

use Webguosai\Core\Container;
use Webguosai\Helper\Arr;
use Webguosai\Helper\Str;

class Ip
{
    /**
     * 获取客户端ip, 优先获取代理
     *
     * @return mixed|string|null
     */
    public static function getClientIp()
    {
        static $ip = NULL;
        if ($ip !== NULL) return $ip;
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos = array_search('unknown', $arr);
            if (false !== $pos) unset($arr[$pos]);
            $ip = trim($arr[0]);
        } elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        // IP地址合法验证
        $ip = (false !== ip2long($ip)) ? $ip : '0.0.0.0';//$_SERVER['REMOTE_ADDR']
        return $ip;
    }

    /**
     * 获取真实ip (与服务器交互的ip)
     */
    public static function getReadIp()
    {
        if (Environment::isCli()) {
            return '127.0.0.1';
        }

        return $_SERVER['REMOTE_ADDR'];
    }

    /**
     * 获取国内随机ip
     *
     * @return string
     */
    public static function getChinaRandom(): string
    {
        $ip_long  = array(
            array('607649792', '608174079'), //36.56.0.0-36.63.255.255
            array('975044608', '977272831'), //58.30.0.0-58.63.255.255
            array('999751680', '999784447'), //59.151.0.0-59.151.127.255
            array('1019346944', '1019478015'), //60.194.0.0-60.195.255.255
            array('1038614528', '1039007743'), //61.232.0.0-61.237.255.255
            array('1783627776', '1784676351'), //106.80.0.0-106.95.255.255
            array('1947009024', '1947074559'), //116.13.0.0-116.13.255.255
            array('1987051520', '1988034559'), //118.112.0.0-118.126.255.255
            array('2035023872', '2035154943'), //121.76.0.0-121.77.255.255
            array('2078801920', '2079064063'), //123.232.0.0-123.235.255.255
            array('-1950089216', '-1948778497'), //139.196.0.0-139.215.255.255
            array('-1425539072', '-1425014785'), //171.8.0.0-171.15.255.255
            array('-1236271104', '-1235419137'), //182.80.0.0-182.92.255.255
            array('-770113536', '-768606209'), //210.25.0.0-210.47.255.255
            array('-569376768', '-564133889'), //222.16.0.0-222.95.255.255
        );
        $rand_key = mt_rand(0, 14);
        return long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
    }

    /**
     * 生成随机ip
     * @return string
     */
    public static function getRandomIp(): string
    {
        return Arr::implode([
            mt_rand(1, 255), mt_rand(1, 255),mt_rand(1, 255),mt_rand(1, 255)
        ], '.');
    }

    /**
     * 输出ip地区信息
     * @param string $ip
     * @param null $file 文件位置
     * @param string $me
     * @param string $sep
     * @param string $unknown
     * @return string
     */
    public static function showLocation(string $ip, $file = null, string $me = '我', string $sep = ' ', string $unknown = '未知'): string
    {
        if ($me && Ip::getReadIp() == $ip) {
            return $me;
        }
        $shows = [];

        if ($file === null) {
//            $file = dirname(__DIR__) . '/../assets/ip/qqwry.dat';
            $file = dirname(__DIR__) . '/../assets/ip/ip2region.xdb';
        }

        // 使用纯真库  composer require itbdw/ip-database
//        $location = \itbdw\Ip\IpLocation::getLocation($ip, $file);
//        if ($location['country'] == '中国') {
//            $shows[] = $location['province']; // 省份
//            $shows[] = $location['city'];     // 城市
//        } else {
//            $shows[] = $location['country']; // 外国
//        }

        // 使用ip2region  composer require chinayin/ip2region-core
        try {
            // TODO 待优化：每次运行不必要再实例化来读取文件
            $obj = \ip2region\XdbSearcher::newWithFileOnly($file);
            $location = $obj->search($ip);
            $arr = Str::explode($location, '|');

            if ($arr[0] == '中国') {
                $shows[] = $arr[2]; // 省份
                $shows[] = $arr[3]; // 城市
            } else {
                $shows[] = $arr[0]; // 外国
            }

            $shows = array_filter($shows); // 去空
        } catch (\Exception $e) {

        }

        if (empty($shows)) {
            $showText = $unknown;
        } else {
            $showText = Arr::implode($shows, $sep);
        }

        return $showText;
    }
}
