<?php

namespace Tests;

use Graze\ArrayMerger\RecursiveArrayMerger;
use Graze\ArrayMerger\ValueMerger\LastNonNullValue;
use Webguosai\Ai\BaiduAi;
use Webguosai\Chart;
use Webguosai\Factory;
use Webguosai\File\File;
use Webguosai\Helper\Arr;
use Webguosai\Helper\Str;
use Webguosai\Http\HttpHeader;
use Webguosai\HttpClient;
use Webguosai\Map\BaiduMap;
use Webguosai\Map\GaodeMap;
use Webguosai\Map\TencentMap;
use Webguosai\Message\DingRobot;
use Webguosai\Message\MyWxPush;
use Webguosai\Message\Qmsg;
use Webguosai\Message\ServerJ;
use Webguosai\Message\WxPusher;
use Webguosai\Runtime;
use Webguosai\Step;
use Webguosai\Http\Response;
use Webguosai\Api\Push;

require_once '../vendor/autoload.php';




/** 文字识别 **/
//$apiKey    = 'HvqDpHrvdGGcdUvGo9N1InNF';
//$secretKey = 'UL8T85fw3joAj4ZZ3nKlojkA5BBIZH22';
//$ai = new BaiduAi($apiKey, $secretKey);

//图片识别为文字
//dump($ai->image2text('image/s.jpg'));

//识别身份证
//dump($ai->imageIdCard('image/s1.jpg'));

/** 语音 **/
//$apiKey    = 'PMa2TaEedcRsu7ToSDxyZ9RC';
//$secretKey = 'HFtslkENgNsbGAuWafvVc7eIeiy2mirR';
//$ai = new BaiduAi($apiKey, $secretKey);

//
//$audio = $ai->getAudio('你好世界', 6, [
//    'spd'  => 5,//语速，取值0-15，默认为5中语速
//    'pit'  => 5,//音调，取值0-15，默认为5中语调
//    'vol'  => 5,//音量，取值0-9，默认为5中音量
//]);
//file_put_contents('ai/wow.wav', $audio);
//
////$text = $ai->getText('https://gw.alipayobjects.com/os/bmw-prod/0574ee2e-f494-45a5-820f-63aee583045a.wav');
//$text = $ai->getText('ai/wow.wav');
//dump($text);

/**  **/
//$arr = [];
//for ($i = 0; $i < 10; $i++) {
//    $arr[] = [
//        'num' => mt_rand(111,999),
//    ];
//}

//dump(Arr::column($arr, 'num'));
//dump($arr);



/** 推送测试 **/
//$url = 'http://127.0.0.1:10111/js.php';
//$client = new HttpClient();
//$ret = Push::start(function() use ($client, $url) {
//    $response = $client->get($url);
//
//    if ($response->httpStatus === 200) {
//        return true;
//    }
//}, 3);
//dump('最终返回结果：', $ret);
//dump('失败次数：', Push::$error);

/** 地图测试 **/

/* 腾讯地图 */
//$map = new TencentMap('X6LBZ-PKOW3-ZE23D-YIH4K-I2YOZ-WPBKK');

// 输入提示
//$suggestion = $map->suggestion('天安门', '北京市');
//dump($suggestion);

//地址转坐标
//湖南省长沙市岳麓区辰泰科技园A座
//-湖南省长沙市开福区四方坪商贸城B-2 东四门 7楼703
//湖南省长沙市雨花区高桥大市场
//湖南省长沙市岳麓区旺龙路56号
//$address = $map->geoAddress('湖南省长沙市雨花区高桥大市场');
//dump($address);

//坐标转地址
//$location = $map->geoLocation($address['location']['lat'], $address['location']['lng']);
//dump($location);

//静态图
//$staticMap = $map->staticMap($address['location']['lng'], $address['location']['lat'], 500, 500, [
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
//4ZFS3XTiggfZcGnDl87asoaPbvxVePZo //某个公众号的ak
//$map = new BaiduMap('B615d4b3ad53e51854eb3a75356acc17');

// 输入提示
//$suggestion = $map->suggestion('天安门', '北京市');
//dump($suggestion);

// 天气查询
//$weather = $map->weather(430101);
//dump($weather);

//地址转坐标
//$address = $map->geoAddress('湖南省长沙市雨花区高桥大市场');
//dump($address);

//坐标转地址
//$location = $map->geoLocation($address['location']['lat'], $address['location']['lng']);
//dump($location);

//静态图
//$staticMap = $map->staticMap($address['location']['lng'], $address['location']['lat'], 400, 400, [
//    'zoom'   => '14',
//    'markers' => $address['location']['lng'].','.$address['location']['lat'],
//    'markerStyles' => 'l,'
//]);
//file_put_contents('map.png', $staticMap);
//dump($staticMap);

//驾车(轻量)
//$direction = $map->dirDriving(28.236919,112.88282, 28.242623, 113.011237);
//dump($direction);

//公交规划(轻量)
//$direction = $map->dirTransit(28.236919,112.88282, 28.242623, 113.011237);
//dump($direction);

//步行规划(轻量)
//$direction = $map->dirWalking(28.236919,112.88282, 28.242623, 113.011237);
//dump($direction);

//骑行规划(轻量)
//$direction = $map->dirBicycling(28.236919,112.88282, 28.242623, 113.011237);
//dump($direction);

//ip定位
//$ip = $map->ip('113.246.95.120');
//dump($ip);

/* 高德地图 */
//$map = new GaodeMap('8566b47583450c2570256cf578697e42');

// 输入提示
//$suggestion = $map->suggestion('天安门', '北京市');
//dump($suggestion);

// 天气查询
//$weather = $map->weather(430101);
//dump($weather);

//地址转坐标
//$address = $map->geoAddress('湖南省长沙市雨花区高桥大市场');
//dump($address);

//坐标转地址
//$lnglat = explode(',', $address['geocodes'][0]['location']);
//$lng = $lnglat[0];
//$lat = $lnglat[1];
//$location = $map->geoLocation($lat, $lng);
//dump($location);

//静态图
//$staticMap = $map->staticMap($lng, $lat, 400, 400, [
//    'zoom'   => '14',
//    'markers' => "mid,0xFF0000,A:{$lng},{$lat}",
//]);
//file_put_contents('map.png', $staticMap);
//dump($staticMap);

//ip定位
//$ip = $map->ip('113.246.95.120');
//$ip = $map->ip('fe80::250:56ff:fec0:8%7');
//dump($ip);

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