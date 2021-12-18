<?php

namespace Tests;

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
$map = new TencentMap('');

//$location = $map->geocoderLocation('39.984154', '116.307490');
//dump($location);

//$address = $map->geocoderAddress('湖南省长沙市');
//dump($address);

//$address = $map->geocoderAddress('北京市海淀区彩和坊路海淀西大街74号');
//dump($address);

//$staticMap = $map->getStaticMap('500*500', [
//    'center' => '28.231092,112.875958', //辰泰 28.231092,112.875958 // 四方坪 28.23608,113.008044
//    'zoom'   => '18',
//    //'markers' => 'color:blue|28.240042,112.864545',
//]);
//file_put_contents('map.png', $staticMap);
//dump($staticMap);

$direction = $map->direction('28.231092,112.875958', '28.23608,113.008044');
dump($direction);


/* 百度地图 */
//$baidu = new BaiduMap([
//    'ak' => ''
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
Response::error('6666', 88, 200);

dump('next');

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