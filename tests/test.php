<?php

namespace Tests;

use Webguosai\Message\DingRobot;
use Webguosai\Message\MyWxPush;
use Webguosai\Message\Qmsg;
use Webguosai\Message\ServerJ;
use Webguosai\Message\WxPusher;
use Webguosai\Runtime;
use Webguosai\Step;

require_once '../vendor/autoload.php';

/** 测试通知类 **/
//$a = DingTalk::pushRobotMsg('1211', 'https://oapi.dingtalk.com/robot/send?access_token=7719bef116d2f0369e3f84ce1e849c03f1224b25acf788937be864dfb61747d4', 'SECc1f4accd76fd0367a67c5740e5ae26023a17f997c4e9f79c8c9083a6efb3f65c');
//var_dump($a);
//$s = new ServerJ([
//    'sendKey' => 'SCT101377TMCywBFWg8HGw07lWinqPnxsv'
//]);
//$s = new DingRobot([
//    'webhook' => 'https://oapi.dingtalk.com/robot/send?access_token=7719bef116d2f0369e3f84ce1e849c03f1224b25acf788937be864dfb61747d4',
//    'secret'  => 'SECc1f4accd76fd0367a67c5740e5ae26023a17f997c4e9f79c8c9083a6efb3f65c',
//    'atAll' => true,
//]);
//$s = new WxPusher([
//    'appToken' => 'AT_SuRUeH96RKRpqTAOF3cMDghEgAj1IysV',
//    'uid' => 'UID_PpIoqyvU6kHqQOP9Ru3ip3MEDShv',
//]);
//$s = new Qmsg([
//    'key' => '1040a08dcc5549f55c5ebdf52d2020a4',
//]);
// 文物总店
//$s = new MyWxPush([
//    'token'       => '78a87KEYHfeTD3N7',
//    'app_id'      => '',
//    'secret'      => '',
//    'open_id'     => 'oRkvhvjnhRsyG0KMlZmJXZvAixZg',
//    'template_id' => 'oI4d7o8pwjxQhanAnA1SYBhBM_QGV_pCT1VI6k2jD5M',
//]);
//// 螳螂科技
//$s = new MyWxPush([
//    'token'       => '78a87KEYHfeTD3N7',
//    'app_id'      => '',
//    'secret'      => '',
//    'open_id'     => 'o-KSp6Zrg7LwNjcyL8RTxeTEQ7Qw',
//    'template_id' => 'Dzf7dYLlHHdG6j3gr0hz5SUs8wF-4wty9XSJHlpDGXU',
//]);
//$send = $s->send('我是标题', "### 支持md吗?\n> 可以".mt_rand(1000, 9999));
//dd($send);

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