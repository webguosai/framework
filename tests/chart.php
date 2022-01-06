<?php

use Webguosai\Chart;
use Webguosai\Helper\Str;

require_once '../vendor/autoload.php';

/** 图表测试 **/
$data = [];
for ($i = 0; $i < 12; $i++) {

    $c = [];
    for ($i2 = 0; $i2 < 10; $i2++) {
        $c[] = mt_rand(1, 100);
    }

    $data[] = [
        'name'  => ($i+1). '月',//Str::random(5, 4),
        'value' => mt_rand(1000, 5000),
        'data'  => $c
    ];
}
echo '<style>fieldset{margin-bottom:20px;text-align:center;font-weight: bold}</style>'; //演示的样式

$chart = new Chart();

function allMethods($class)
{
    $methods = get_class_methods($class);
    $data = [];
    foreach ($methods as $method) {
        if ($method != '__construct') {
            $data[] = $method;
        }
    }
    return $data;
}

$methods = allMethods($chart);
$methods = array_reverse($methods);
foreach ($methods as $method) {
    echo '<fieldset><legend>'.$method.'</legend>';
    echo $chart->$method($data);
    echo '</fieldset>';
}


//echo '<fieldset><legend>pieSimple</legend>';
//echo $chart->pieSimple($data, [
//    'title' => [
//        'text'    => '浏览器使用比率',
//        'subtext' => '12月份',
//    ]
//]);
//echo '</fieldset>';
//
//dd(json_encode(['a' =>1], JSON_FORCE_OBJECT));


//echo '<fieldset><legend>test</legend>';
//echo $chart->barDatasetSimple0($data);
//echo '</fieldset>';
