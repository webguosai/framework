<?php

namespace Tests;

use Graze\ArrayMerger\RecursiveArrayMerger;
use Graze\ArrayMerger\ValueMerger\LastNonNullValue;
use Webguosai\Ai\BaiduAi;
use Webguosai\Core\Container;
use Webguosai\Crypt\Aes;
use Webguosai\Crypt\Crypt;
use Webguosai\Crypt\Rsa;
use Webguosai\Helper\Helper;
use Webguosai\Http\Cors;
use Webguosai\Message\QyWeChat;
use Webguosai\Message\Iyuu;
use Webguosai\Translate\CaiYun;
use Webguosai\Translate\Findmyip;
use Webguosai\Util\Cli;
use Webguosai\Util\Data;
use Webguosai\Util\Format;
use Webguosai\Util\Ip;
use Webguosai\Robot\TuLing;
use Webguosai\Translate\Baidu;
use Webguosai\Translate\Google;
use Webguosai\Translate\Translatedlabs;
use Webguosai\Translate\YouDao;
use Webguosai\Util\CharCodeAt;
use Webguosai\Util\CountdownFormat;
use Webguosai\CrackCaptcha\Chaojiying;
use Webguosai\HttpAgentIp\Xq;
use Webguosai\Http\Request;
use Webguosai\Util\Arithmetic;
use Webguosai\Util\Category;
use Webguosai\Chart;
use Webguosai\Factory;
use Webguosai\File\File;
use Webguosai\Helper\Arr;
use Webguosai\Helper\Str;
use Webguosai\Http\Header;
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
use Webguosai\Util\Enum;
use Webguosai\Util\EnvHandle;
use Webguosai\Util\Environment;
use Webguosai\Util\Faker;
use Webguosai\Util\Lottery;
use Webguosai\Util\Qrcode;
use Webguosai\Util\Jwt;
use Webguosai\Util\Regex;
use Webguosai\Util\Runtime;
use Webguosai\Util\Csv;
use Webguosai\Util\Session;
use Webguosai\Util\Step;
use Webguosai\Http\Response;
use Webguosai\Api\Push;
use Webguosai\Util\TextExtract;
use Webguosai\Util\Tools;
use Webguosai\Util\Url;
use Webguosai\Util\Itertools;
use Webguosai\Xml\Array2Xml;
use Webguosai\Xml\Xml2Array;

require_once '../vendor/autoload.php';

//$array = [
//    ['id' => 1, 'name' => 'aaa'],
//    ['id' => 2, 'name' => 'bbb'],
//    ['id' => 3, 'name' => 'ccc'],
//];
////$array = [
////    "gong" => "公办",
////    "min" => "民办"
////];
//dd(Arr::options($array));

/** 数据获取 **/
// Data::load([
//    'id'=> 0,
//    'bid'=> '',
//    'cid'=> 10,
//    'url' => 'http://',
//    'people' => [
//        'name' => '张三',
//        'sex' => '男'
//    ],
//    'levels' => [
//        ['id' => 1, 'name' => '111'],
//        ['id' => 2, 'name' => '222'],
//        ['id' => 3, 'name' => '333'],
//        ['id' => 4, 'name' => '444'],
//        ['id' => 5, 'name' => '555'],
//    ]
// ]);
// dump(Data::get('people'));
// dump(Data::getId('id'));
// dump(Data::getId('bid'));
// dump(Data::getId('cid'));
//dump(Data::getIds('levels', 'id'));
//dump(Data::get('people.name'));
//dump(Data::get('people2'));

/** ip地址库 **/
//dd(Ip::showLocation('1.32.238.255'));
//while (true) {
//    $ip = Ip::getChinaRandom();
////    $ip = Ip::getRandomIp();
//    Runtime::start('k');
//
//    dump($ip . ' ' . Ip::showLocation($ip) . ' ' . Runtime::show('k', null, 5));
//
//    usleep(1000);
//}




/** xml **/
// xml to array
//$xml = '<propertyList>
//  <rental modTime="2021-12-01-05:56:34" status="leased">
//    <agentID>002442</agentID>
//    <uniqueID>R2-3020378</uniqueID>
//    <underOffer value="no"/>
//    <priceView>Deposit Taken</priceView>
//    <rent period="week" display="yes">780</rent>
//    <bond/>
//  </rental>
//</propertyList>';
//
//$array = Xml2Array::createArray($xml);
//File::save('1.php', $array);
//dd($array);

// 输出为xml
//$array = array (
//    'propertyList' =>
//        array (
//            'rental' =>
//                array (
//                    'agentID' => '002442',
//                    'uniqueID' => 'R2-3020378',
//                    'underOffer' =>
//                        array (
//                            '@value' => '',
//                            '@attributes' =>
//                                array (
//                                    'value' => 'no',
//                                ),
//                        ),
//                    'priceView' => 'Deposit Taken',
//                    'rent' =>
//                        array (
//                            '@value' => '780',
//                            '@attributes' =>
//                                array (
//                                    'period' => 'week',
//                                    'display' => 'yes',
//                                ),
//                        ),
//                    'bond' => '',
//                    '@attributes' =>
//                        array (
//                            'modTime' => '2021-12-01-05:56:34',
//                            'status' => 'leased',
//                        ),
//                ),
//        ),
//);
//$xml = Array2Xml::createXML($array);
//$xml->save('1.xml');


/** cli **/
//echo '请输入中文：';
//dump(Cli::getChinaInput());
//Cli::info('info');
//Cli::error('error', false);
//Cli::success('success');
//Cli::printLine('一行数据');
//Cli::printLine('一行数据', 'error');
//Cli::printLine('一行数据', 'success');
//Cli::table([
//    [ '张三', '男', '20'],
//    [ '李四', '女', '19']
//]);
//Cli::table([
//    [
//        '名称' => '张三',
//        '性别' => '男',
//        '年龄' => '20',
//    ], [
//        '名称' => '李四',
//        '性别' => '女',
//        '年龄' => '19',
//    ]
//]);
// 使用Climate
//Cli::getClimate()->tab()->out('I am all sorts of indented.');


/** 容器 **/
//Container::getInstance()->bind('test', 'this is test');
//Container::getInstance()->bind('test', 111);
//Container::getInstance()->bind('test', [1,2,3,4]);
//Container::getInstance()->bind('test', function(){
//    return 'test';
//});
//Container::getInstance()->bind([
//    'test' => [1,2,3,4],
//    'test2' => 'this is test2'
//]);
//Container::getInstance()->bind(Faker::class);
//dump(Container::getInstance()->bindings);


//Container::getInstance()->bind('cache', function($name, $name2){return 'cache '.$name.'  '. $name2;});
////dump(Container::getInstance()->bindings);
//dump(Container::getInstance()->make('cache', ['haha', 'hehe']));


//Container::getInstance()->bind('cache2');
////dump(Container::getInstance()->bindings);
//dump(Container::getInstance()->make('cache2'));


/** session **/
//设置
//Session::setConfig('F:\www\framework\tests');
//Session::getInstance()->set('user', ['a', 'b', 'c', 'd']);
//dump(Session::getInstance()->get('user'));
//sleep(3);
//dump(Session::getInstance()->get('user'));
//Session::getInstance()->delete('user');


/** 鉴权 **/
//$jwt = new \Webguosai\Authentication\JwtToken('123');
//dump($jwt->authenticate([
//    'name' => 'guosai',
//    'password' => 'guosai',
//    'avatar' => 'guosai.png',
//], 10));
//try {
//    dump($jwt->parse());
//} catch (\Exception $e) {
//    dump($e->getMessage());
//}

/** 消息推送 **/
// $message = new QyWeChat([
//     'key' => ''
// ]);
// $message->send('标题', mt_rand(100, 999), 'http://www.baidu.com');

/** 跨域 **/
//Cors::setting();


/** 概率抽奖类 **/
//$awards = array(
//    '0' => array('id' => 1, 'title' => '平板电脑', 'probability' => 0.5),
//    '1' => array('id' => 2, 'title' => '数码相机', 'probability' => 0.15),
//    '2' => array('id' => 3, 'title' => '音箱设备', 'probability' => 0.25),
//    '3' => array('id' => 4, 'title' => '4G优盘', 'probability' => 24.5),
//    '4' => array('id' => 5, 'title' => '10Q币', 'probability' => 3.5),
//);
//$lottery = (new Lottery())->init($awards);
//
//// 初始化抽奖配置，抽奖
//for ($i = 0; $i < 10; $i++) {
//    dump($lottery->getDraw());
//}

/** 工具集 **/
//dump(Tools::isWxBrowser());
//dump(Tools::uuid());


// 计算两个坐标之前的距离(单位：米)
//提供一个四方坪B2栋由西到东的两个坐标
//dump(Tools::getDistance('113.014186', '28.241977', '113.014662', '28.242029'));

//dump(Tools::getSquarePoint('113.014186', '28.241977'));


/** Enum **/
//dump(\Webguosai\Tests\Enum\UserTypeEnum::values());
//dump(\Webguosai\Tests\Enum\UserTypeEnum::maps());
//dump(\Webguosai\Tests\Enum\UserTypeEnum::in(['client2', 'client']));
//dump(\Webguosai\Tests\Enum\UserTypeEnum::in('client'));
//dump(\Webguosai\Tests\Enum\UserTypeEnum::getDefault());
// dump(\Webguosai\Tests\Enum\UserTypeEnum::getMapValue('client'));
// dump(\Webguosai\Tests\Enum\UserTypeEnum::getMapValue(null));
// dump(\Webguosai\Tests\Enum\UserTypeEnum::getMapValue([null, 'client']));
//dump(\Webguosai\Tests\Enum\UserTypeEnum::getMapKey('客户'));
//dump(\Webguosai\Tests\Enum\UserTypeEnum::comment());


/** url **/
//dd(Url::isUrl('https://www.php.cn/php-weizijiaocheng-329439.html'));
//dump(Url::getExtension('12.3.jpg')); // jpg
//dump(Url::getFileName('https://github.com/top-think/think-validate/blob/master/src/Validate.php')); // Validate
//dump(Url::getBaseName('https://github.com/top-think/think-validate/blob/master/src/Validate.php')); // Validate.php
//dump(Url::getPath('http://192.168.31.148:9011/uploads/images/20230425/30a91322c446495b79f7a9fc3b03cf0c.png')); // /uploads/images/20230425/30a91322c446495b79f7a9fc3b03cf0c.png
//dump(Url::getPath('javascript:alert(123);')); // 不是url
//dump(Url::getPath('http://127.0.0.1:9011/index.php?m=content&c=index&a=lists&catid=12#123')); // 不是url
//dump(Url::getPath('http://127.0.0.1:9011/ab.php?s=/a/b/c/')); // 不是url
//dump(Url::getPath('http://127.0.0.1:9011')); // 不是url

/** 二维码 **/
// 生成二维码
//$logo = [
//    'file' => '../assets/images/logo.jpg',
//];
//$label = [
//    'text' => '汉字label',
//];
//$qr = Qrcode::create('good luck', 300, $logo, $label);
////$qr->writeString();
////$qr->writeDataUri(); // base64
//$qr->writeFile('1.png'); // 写入文件 //
//
//// 解码二维码
////dd(Qrcode::decode('1.png'));
//dd(Qrcode::decode($qr->writeString(), Qrcode::SOURCE_TYPE_BLOB));


/** 文本提取 **/
//$text = [
//    '身份证号：51250119910927226x 收货地址张三收货地址：成都市武侯区美领馆路11号附2号 617000  136-3333-6666',
//    '我叫张三,今年18岁,男孩子,电话17111111111, 身份证：512501199109272278 电话2：  １８１６３７１１２３４  wx6666 hxy051019',
//];
//
//$id = new TextExtract($text);
//dump($id->getName());
//dump($id->getSex());
//dump($id->getAge());
//dump($id->getMobile());
//dump($id->getWeChat());
//dump($id->getIdCard());


/** Ip **/
//dump(Ip::getReadIp());


/** Request **/
//dump(Request::getFullUrl());
//dump(Request::getSiteUrl());
//dump(Request::getReferer());
//dump(Request::server('argv'));
//dump(Request::getHeaders());

/** Environment **/
//dump(Environment::get());
//dump(Environment::isCli());


/** 机器人 **/
//apikey在这里有很多：https://github.com/arckalsun/soulapp_im_robot/blob/265ae75e8dd30e8daecb7798909c48bd31ca7ed1/src/main/resources/robots.json
//$tl = new TuLing('f222eaa9ede84cc6bfdd6f6d2ca4a589', '371856');
//while (true) {
//    $res = $tl->replyText('吃的');
//    dump($res);
//    sleep(1);
//}

/** CharCodeAt **/
//$string = 'Hi';
//dump(CharCodeAt::toString($string));
//dump(CharCodeAt::toArray($string));
//dump(CharCodeAt::toNumber('H'));

/** aes **/
//$word = [
//    'name1' => '123',
//    'name2' => '456'
//];
//$word = 123;
//$key = '2c920f9579cb89K9';
//$iv = 'Qa5da1EbsEAygd18';
//Aes::config($key, $iv, true);
//$encode = Aes::encrypt($word);
//dump($encode);
//dd(Aes::decrypt($encode));


//$key = 'key123';
//$iv = '1234567890123456';
//Aes::config($key, $iv);
//$encode = Aes::encrypt($word);
//dump($encode);
//dd(Aes::decrypt($encode));

/** Rsa **/
// // 1. 密钥 (abc任选一种)
// // a 一开始我们没有密钥文件,使用如下代码,可以生成密钥文件
// // $keys = Rsa::createKeysFile();
// // b 获取来自目录文件中密钥(密钥包含公钥和私钥)
// // $keys = Rsa::getKeysByDir();
// // c 生成密钥 (这里获取到的密钥可以自行去保存,读取)
// $keys = Rsa::createKeys();
// dump($keys);
//
// // 2. 加解密
// $data       = ['总结：公钥用于加密数据，私钥用于解密数据。公钥可以被分享给其他人，而私钥应该保密。'];
// $ciphertext = Rsa::encrypt($data, $keys['privateKey']);
// dump('加密：' . $ciphertext);
// dump('解密：');
// dump(Rsa::decrypt($ciphertext, $keys['publicKey']));

/** 翻译 **/
//$b = new Baidu([
//    'appId' => '20200729000529030',
//    'secretKey' => 'ATTEvDOWLO1U5rD8U3ft'
//]);
//$b = new YouDao([
//    'appId'     => '7fda4dee3e6448ec',
//    'secretKey' => 'WgWk79cH1WK0EYKZagvvm1NTjiDnePTS',
//]);
//$b = new Translatedlabs();
//$b = new Google([
//    'key'  => 'AIzaSyC1pvAVod6kZa5g8LOhArHrAchbLHEXUd0',
//    'http' => [
//        'proxyIps' => ['127.0.0.1:9528']
//    ]
//]);
//$b = new CaiYun([
////    'token' => '3975l6lr5pcbvidl6jl2',//官方
//    'token' => 'hlgg9mzpucpmih3p3795'
//]);
// $b = new Findmyip();

//

//
// while (true) {
//    try {
//        dump($b->translate('你好，世界', 'en'));
//        // dump($b->translate('china.', 'zh-CN'));
//        // dump($b->language('中国'));
//    } catch (\Exception $e) {
//        Cli::error($e->getMessage());
//    }
// }


/** Format **/
//dd(Format::formatMoneyCurrency('9999999999999', 0, '$',  'right'));
//dump(Format::formatNumber(999));
//dump(Format::formatNumber(9999));
//dump(Format::formatNumber(12600));
//dump(Format::formatNumber(88888888));
//dump(Format::formatNumber(99990000));
//dump(Format::formatNumber(188888888));
//dump(Format::reserveDecimal(888.993456789, 2));
//dump(Format::reserveDecimal(2.7800000000000002, 2));

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
//dump(Date::formatShow($sqlValue, $dateFormat, $timeFormat));
//dump(Date::diffDay('2000-01-01 09:00:00', '2000-02-01 09:00:00'));
//dump(Date::diffDay('2001/01/01', '2002/01/01'));


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
//dump(Faker::name('女')); // 姓名
//dump(Faker::firstName()); // 姓
//dump(Faker::lastName()); // 名
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
//dump(Faker::datetime(null)); //日期时间
//dump(Faker::datetime()); //日期时间
//dump(Faker::datetime('2022-08-15 00:00:00', '2022-08-16 00:00:00')); //日期时间
//dump(Faker::date(null)); // 日期
//dump(Faker::date()); // 日期
//dump(Faker::date('2022-08-15', '2022-08-16')); // 日期
//dump(Faker::time(null)); // 时间
//dump(Faker::time()); // 时间
//dump(Faker::time('09:00:00', '09:00:10')); // 时间
//dump(Faker::ids()); // ids
//dump(Faker::price()); // 金额
//dump(Faker::currency()); // 货币
//dump(Faker::password()); // 密码
//dump(Faker::job()); // 工作
//dump(Faker::project());// 项目
//dump(Faker::carProject());// 汽车项目
//dump(Faker::car());// 汽车
//dump(Faker::carLabel());// 汽车标签


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
//$code = Jwt::encode([1,2,3,4], 5);
//dump($code);
//dd(JWT::decode($code));

/** 将整数秒转换成xx天xx时xx分xx秒格式 **/
//dump(CountdownFormat::getFormat(60*60*24*30+1));//最简单的调用
//dump(CountdownFormat::getFormat(60*60*24*30+1,'dhm'));//自定义返回格式,默认xx天xx时xx分xx秒
//dd(CountdownFormat::getFormat(60*60*24*30+1,'dhm',['d'=>'day','h'=>'hour','m'=>'min','s'=>'seconds']));//自定义返回格式,时间单位,默认天时分秒


/** 数组映射 **/
//$arr = [
//    'sai',
//    'dan',
//];
//$data = Arr::map(function ($key, $value) {
//    // 返回字符串，不会修改key
////    return $value;
//    // 返回数组，会修改key
////    return [
////        $value => strtoupper($value),
////    ];
//}, $arr);
//dump($data);

//dd(Arr::implode([1,2,3,4,5]));
//dd(Str::explode('1,2,3,4'));
//dd(substr_replace('中文啊12345678', '****', 3, 4));

//dd(Str::mask('1801234567中'));
//dump(Arr::in('user.info', ['user.del', 'user.info', 'user.show']));
//dump(Arr::in(['user.get', 'user.index'], ['user.del', 'user.*', 'user.show', 'user.create']));
//dump(Arr::dot([
//    'id' => 1,
//    'user' => [
//        'name' => "gs",
//        'age' =>100,
//        'user2' => [
//            'name' => "gs",
//            'age' =>11
//        ]
//    ]
//], '_'));


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
//$a = $c->get('F:\www\captcha\assets\captcha/google.jpg');
//dd($a['pic_str']);
//$c->getStr(base64_encode(file_get_contents('./captcha/1.jpg')));


/** 文件类 **/
//dump(File::getAllFiles('./a/b/c/d'));
//$a = File::mkFile('./a/b/c/d\\asp.txt');
//$a = File::mkFile('asp2.txt');
//$a = File::mkFile('c/');
//$a = File::scandir('../src/');
//File::rmDir('./dir');
//dd($a);
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
//$weather = $map->weather(430100);
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
//$weather = $map->weather(430100);
//dump($weather);

//地址转坐标
//$address = $map->geoAddress('湖南省长沙市雨花区高桥大市场');
//dump($address);

//坐标转地址
//$lnglat = explode(',', $address['location']);
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
//$ip = $map->ip('113.246.166.139');
//$ip = $map->ip('240e:387:405:200:6664:4aff:fe5c:94ae');
//dump($ip);

/** 响应类测试 **/
//Response::setType('jsonp');
//Response::error('6666', 88, 200);
//Response::success('6666', 88, ['a' => true]);

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
//dump(Str::concatArray('3--::--标签_3--::--#00aaaa,4--::--标签_4--::--#00ddbb', ['id', 'name', 'color']));
//dump(Str::is('user.*', 'user.index'));

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
