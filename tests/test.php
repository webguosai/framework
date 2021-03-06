<?php

namespace Tests;

use Graze\ArrayMerger\RecursiveArrayMerger;
use Graze\ArrayMerger\ValueMerger\LastNonNullValue;
use Webguosai\Ai\BaiduAi;
use Webguosai\Crypt\Aes;
use Webguosai\Crypt\Crypt;
use Webguosai\Helper\Helper;
use Webguosai\Translate\Baidu;
use Webguosai\Translate\Translatedlabs;
use Webguosai\Translate\YouDao;
use Webguosai\Util\CountdownFormat;
use Webguosai\CrackCaptcha\Chaojiying;
use Webguosai\HttpAgentIp\Xq;
use Webguosai\Request;
use Webguosai\Util\Arithmetic;
use Webguosai\Util\Category;
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
use Webguosai\Util\Date;
use Webguosai\Util\EnvHandle;
use Webguosai\Util\Faker;
use Webguosai\Util\Jwt;
use Webguosai\Util\Runtime;
use Webguosai\Util\Csv;
use Webguosai\Util\Step;
use Webguosai\Http\Response;
use Webguosai\Api\Push;
use Webguosai\Util\Zip;
use Webguosai\Util\Itertools;

require_once '../vendor/autoload.php';

/** aes **/
$word = [
    'name1' => '123',
    'name2' => '456'
];
$word = 123;
$key = '2c920f9579cb89K9';
$iv = 'Qa5da1EbsEAygd18';
Aes::config($key, $iv, true);
$encode = Aes::encrypt($word);
dump($encode);
dd(Aes::decrypt($encode));


//$key = 'key123';
//$iv = '1234567890123456';
//Aes::config($key, $iv);
//$encode = Aes::encrypt($word);
//dump($encode);
//dd(Aes::decrypt($encode));

/** 翻译 **/
// 20220726001283686
// UzhkImxnMMMw9a4FchQe

//$b = new Baidu('20220726001283686', 'UzhkImxnMMMw9a4FchQe');
//$b = new YouDao('7fda4dee3e6448ec', 'WgWk79cH1WK0EYKZagvvm1NTjiDnePTS');
//$b = new Translatedlabs();
//
//while (true) {
//    try {
////        dump($b->translate('苹果', 'en'));
//        dump($b->language('中国'));
//    } catch (\Exception $e) {
//        dump('错误：'.$e->getMessage());
//    }
//}

/** Helper **/
//dd(Helper::formatMoneyCurrency('9999999999999', '$', 0, 'right'));

/** Date **/
//dump(Date::getRangeDateTime([
//    '2020-01-01',
//    '2022-01-01'
//]));

//$sqlValue = '2022-06-01';
//$sqlValue = '20:00:00';
//$sqlValue = '2022-01-01 20:00:00';
//
//$dateFormat = 'm/d/Y';
//$timeFormat = 'H点i分s秒';
//dd(Date::formatShow($sqlValue, $dateFormat, $timeFormat));



/** env操作类 **/
//// 设置
//EnvHandle::setConfig(__DIR__ . '/.env');
//// 获取所有
//EnvHandle::all();
//// 设置一个(有则修改，无则增加)
//EnvHandle::set('key', 'value');
//// 批量插入
//EnvHandle::insert([
//    'key1' => 'value1',
//    'key2' => 'value2',
//    'key3' => 'value3'
//]);
//// 获取单个
//EnvHandle::get('key');
//// 移除
//EnvHandle::remove('key');


/** python itertools模块 **/
// 迭代所有组合
//$permutations = Itertools::permutations('123');
//foreach ($permutations as $permutation) {
//    dump(implode($permutation));
//}

/** 对称加密类 **/
//Crypt::setKey('key123456');
////$data = '中文';
//$data = ['中文'];
//$encode = Crypt::encode($data);
//$decode = Crypt::decode($encode);
//
//dump($data);
//dump($encode);
//dump($decode);

/** faker生成假数据 **/
//dump(Faker::name()); // 姓名
//dump(Faker::sex()); // 性别
//dump(Faker::is()); // 1 - 0
//dump(Faker::chinese()); // 汉字
//dump(Faker::school('中职学校')); //学校
//dump(Faker::company()); //公司
//dump(Faker::bank()); //银行
//dump(Faker::country()); //国家
//dump(Faker::region()); //省市区
//dump(Faker::province()); //省份
//dump(Faker::city()); //城市
//dump(Faker::area()); //地区
//dump(Faker::mobile()); //手机
//dump(Faker::idCard()); //身份证
//dump(Faker::website()); //网址
//dump(Faker::email()); //邮箱
//dump(Faker::account()); //帐号
//dump(Faker::ip()); //ipv4
//dump(Faker::color()); //颜色值
//dump(Faker::news()); //新闻标题
//dump(Faker::title()); //标题
//dump(Faker::title(20)); //标题
//dump(Faker::question()); //问题
//dump(Faker::number(1, 20)); //数字
//dump(Faker::datetime()); //日期时间
//dump(Faker::date()); // 日期
//dump(Faker::time()); // 时间
//dump(Faker::ids()); // ids
//dump(Faker::price()); // 金额
//dump(Faker::currency()); // 货币
//dump(Faker::password()); // 密码


/** csv **/
//$content = <<<EOF
//张三\t男\t18岁
//李四\t女\t19岁
//王五\t未知\t20岁
//EOF;
////$content = file_get_contents('content.txt');
////dd(Csv::toArray($content, false));
//
//$sql = Csv::toInsertSql($content, 'student');
//dd($sql);

/** JWT **/
//Jwt::setConfig('key123456', 'domain.com');
//$code = Jwt::encode(1111, 5);
//dump($code);
//dd(JWT::decode($code));


/** 将整数秒转换成xx天xx时xx分xx秒格式 **/
//dump(CountdownFormat::getFormat(60*60*24*30+1));//最简单的调用
//dump(CountdownFormat::getFormat(60*60*24*30+1,'dhm'));//自定义返回格式,默认xx天xx时xx分xx秒
//dd(CountdownFormat::getFormat(60*60*24*30+1,'dhm',['d'=>'day','h'=>'hour','m'=>'min','s'=>'seconds']));//自定义返回格式,时间单位,默认天时分秒


/** 数组映射 **/
//$arr = [
//    'name1' => '111',
//    'sex1' => '男',
//    'job1' => null,
//    'age' => null,
//    'other1' => [],
//    'other2' => [1,2,3],
//];
//$table = [
//    'name' => 'name1',
//    'job'  => 'job1',
//    'sex'  => 'sex1',
//];
//
//dd(Arr::map($arr, $table));
//dd(Arr::implode([1,2,3,4,5]));
//dd(Str::explode('1,2,3,4'));
//dd(substr_replace('中文啊12345678', '****', 3, 4));

//dd(Str::mask('1801234567中'));



/** 代理ip **/
//$xq = new Xq([
//    'uid'  => '81275',
//    'ukey' => '327AA79E7FBE4B0346893D957BD2E0A4',//在绑定白名单时需要
//    'vkey' => '4178C765155FC46CF91BA7673F418CDF',//在获取代理ip时需要
//]);
////绑定服务器ip白名单
////$a = $xq->bindWhiteList('113.247.20.201');
////dd($a);
//
////获取代理ip
//$list = $xq->get(5);
//dump($list);


/** 验证码接口 **/
//$c = new Chaojiying([
//    'user'     => 'a3298445815',
//    'pass'     => 'a5436511',
//    'softid'   => '928030',
//]);
//$a = $c->get('./captcha/3.jpg');
//dd($a);
//$c->getStr(base64_encode(file_get_contents('./captcha/1.jpg')));

/** 压缩 **/
//$zip = Zip::create('image.zip', 'image');

//Zip::extract('images.zip', '.');


/** 文件类 **/
//$a = File::mkFile('./a/b/c/d\\asp.txt');
//$a = File::mkFile('asp2.txt');
//$a = File::mkFile('c/');
//$a = File::scandir('../src/');
//dd($a);
//dd(File::getExtension('12.3.jpg'));
//dump(File::fileSizeToBytes(919436274));
//File::rmDir('F:\www\framework\tests\11');


/** 红包 **/

//$a = Arithmetic::getRedPackage(999, 30,10, 50);
//dd($a);

/** 无限级分类 **/
//$list = [
//    ['class_id' => 1, 'name' => '1-1', 'parent_id' => 0],
//    ['class_id' => 2, 'name' => '1-2', 'parent_id' => 1],
//    ['class_id' => 3, 'name' => '1-3', 'parent_id' => 1],
//    ['class_id' => 4, 'name' => '1-2-1', 'parent_id' => 2],
//    ['class_id' => 5, 'name' => '2-1', 'parent_id' => 0],
//    ['class_id' => 6, 'name' => '2-2', 'parent_id' => 4],
//];
//$category = new Category(['class_id', 'parent_id', 'name', 'cname']);
//dump($category->getTree($list));



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
//dump(Str::shortText('1111111111'));
//dump(Str::shortText('22222'));
//dump(Str::split('123456'));
//dump(Str::split('中文123'));
//dump(Str::split([1,2,3]));

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
