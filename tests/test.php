<?php

namespace Tests;

use Webguosai\File\File;
use Webguosai\Helper\Arr;
use Webguosai\Http\HttpHeader;
use Webguosai\Map\BaiduMap;
use Webguosai\Map\TencentMap;
use Webguosai\Message\DingRobot;
use Webguosai\Message\MyWxPush;
use Webguosai\Message\Qmsg;
use Webguosai\Message\ServerJ;
use Webguosai\Message\WxPusher;
use Webguosai\Runtime;
use Webguosai\Step;
use Webguosai\Http\Response;

require_once '../vendor/autoload.php';

/** 地图测试 **/

/* 腾讯地图 */
//$map = new TencentMap('X6LBZ-PKOW3-ZE23D-YIH4K-I2YOZ-WPBKK');

//坐标转地址
//$location = $map->geoLocation('39.984154', '116.307490');
//$location = $map->geoLocation('28.20057227', '112.83502147');
//dump($location);

//地址转坐标
//$address = $map->geoAddress('湖南省长沙市岳麓区辰泰科技园A座');
//dump($address);

//湖南省长沙市岳麓区辰泰科技园A座
//-湖南省长沙市开福区四方坪商贸城B-2 东四门 7楼703
//湖南省长沙市雨花区高桥大市场
//湖南省长沙市岳麓区旺龙路56号
//$address = $map->geoAddress('湖南省长沙市雨花区高桥大市场');
//dump($address);

//静态图
//$staticMap = $map->staticMap('500*500', [
//    'center' => $address['location']['lat'].','.$address['location']['lng'],//'28.231092,112.875958', //辰泰 28.231092,112.875958 // 四方坪 28.23608,113.008044
//    'zoom'   => '14',
//    'markers' => 'color:blue|'.$address['location']['lat'].','.$address['location']['lng'],
//]);
//file_put_contents('map.png', $staticMap);
//dump($staticMap);

//驾车
//$direction = $map->dirDriving(28.231092,112.875958, 28.23608, 113.008044);
//dump($direction);

//公交
//$direction = $map->dirTransit(28.231092,112.875958, 28.23608, 113.008044);
//dump($direction);

//步行
//$direction = $map->dirWalking(28.231092,112.875958, 28.23608, 113.008044);
//dump($direction);

//骑行
//$direction = $map->dirBicycling(28.231092,112.875958, 28.23608, 113.008044);
//dump($direction);

//ip定位
//$ip = $map->ip('113.246.95.120');
//dump($ip);

//$regions = $map->regions();
//File::save('regions.php', ($regions));
//var_dump($regions);

/* 百度地图 */
//$baidu = new BaiduMap([
//    'ak' => '4ZFS3XTiggfZcGnDl87asoaPbvxVePZo',//某个公众号的ak
//    'ak' => 'B615d4b3ad53e51854eb3a75356acc17'
//]);
//获取 经纬度
//dd($baidu->geocoding([
//    'address' => '北京市海淀区上地十街10号'
//]));
//获取 地区信息
//dd($baidu->reverse_geocoding([
//    'location' => '38.76623,116.43213'
//]));


/** 响应类测试 **/
//Response::error('6666', 88, 200);


/** 获取随机内容 **/
//var_dump(\Webguosai\Helper\Str::random(10));
//var_dump(\Webguosai\Helper\Str::random(10, 0));
//var_dump(\Webguosai\Helper\Str::random(10, 1));
//var_dump(\Webguosai\Helper\Str::random(10, 2));
//var_dump(\Webguosai\Helper\Str::random(10, 3));
//var_dump(\Webguosai\Helper\Str::random(10, 4));




/** 测试阶梯类 **/
//$points = [
//    [
//        'point' => '4000',
//        'level' => 'L1',
//        'name'  => '筑基学徒',
//        'pic'   => 'https://cdn.hnsy17.com/upload/2021-12-09/cf0acbf3bc6c3e555fc319226a714468.png',
//    ], [
//        'point' => '9000',
//        'level' => 'L2',
//        'name'  => '安全里手',
//        'pic'   => 'https://cdn.hnsy17.com/upload/2021-12-09/bd4d6eb751d06c60deb7d4778ffdaf6a.png',
//    ], [
//        'point' => '15000',
//        'level' => 'L3',
//        'name'  => '资深专家',
//        'pic'   => 'https://cdn.hnsy17.com/upload/2021-12-09/c2aab1fff86a83a47d3c104c3261a387.png',
//    ], [
//        'point' => '20000',
//        'level' => 'L4',
//        'name'  => '一代宗师',
//        'pic'   => 'https://cdn.hnsy17.com/upload/2021-12-09/872db0c0c5c8837f180aa57c1467dc15.png',
//    ], [
//        'point' => '-',
//        'level' => 'L5',
//        'name'  => '大神传说',
//        'pic'   => 'https://cdn.hnsy17.com/upload/2021-12-09/b07fa1f2b3465086053a8bff79c32835.png',
//    ]
//];
//$points = [];
//$step   = new Step($points, 'point');
//var_dump($step->get('24999'));
//var_dump($step->getName('24999'));
//var_dump($step->all());


/** 测试运行类 **/

//Runtime::start(1);
//sleep(1);
//var_dump(Runtime::show(1));
//
//Runtime::start(2);
//sleep(2);
//var_dump(Runtime::show(2));
//
//
//var_dump(Runtime::show(1));