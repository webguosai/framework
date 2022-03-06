<?php

use Webguosai\Chart;
use Webguosai\Helper\Str;

require_once '../vendor/autoload.php';

/** 图表测试 **/
$chart = new Chart();

echo '<style>fieldset{margin-bottom:20px;text-align:center;font-weight: bold}</style>'; //演示的样式

//$methods = allMethods($chart);
//$methods = array_reverse($methods);
//foreach ($methods as $method) {
//    echo '<fieldset><legend>'.$method.'</legend>';
//    echo $chart->$method($data);
//    echo '</fieldset>';
//}

//地图
showDemo('地图 map', [
    ['name' => '湖南', 'value' => 66],
    ['name' => '内蒙古', 'value' => 55],
    ['name' => '新疆', 'value' => 11],
], 'map', [], $chart);



// 饼图
showDemo('饼图 pie', [
    ['name' => '新增客户', 'value' => mt_rand(100,999)],
    ['name' => '累计客户', 'value' => mt_rand(100,999)],
    ['name' => '有效客户', 'value' => mt_rand(100,999)],
], 'pie', [
    'title' => [
        'text'    => '大标题',
        'subtext' => '小标题',
        'left'    => 'center'
    ]
], $chart);

//漏斗图
showDemo('漏斗图 funnel', [
    ['name' => '王五', 'value' => 60],
    ['name' => '赵六', 'value' => 40],
    ['name' => '牛七', 'value' => 20],
    ['name' => '李四', 'value' => 80],
    ['name' => '张三', 'value' => 100],
], 'funnel', [], $chart);

// 柱状图
showDemo('柱状图 bar', [
    'name' => ['2021-01', '2021-02', '2021-03', '2021-04', '2021-05'],
    'data' => [
        [
            'name' => '新增客户',
            'data' => [mt_rand(100,999), mt_rand(100,999), mt_rand(100,999), mt_rand(100,999), mt_rand(100,999)],
        ], [
            'name' => '累计客户',
            'data' => [mt_rand(100,999), mt_rand(100,999), mt_rand(100,999), mt_rand(100,999), mt_rand(100,999)],
        ], [
            'name' => '有效客户',
            'data' => [mt_rand(100,999), mt_rand(100,999), mt_rand(100,999), mt_rand(100,999), mt_rand(100,999)],
        ]
    ]
], 'bar', [], $chart);


// 折线图
showDemo('折线图 line', [
    'name' => ['2021-01', '2021-02', '2021-03', '2021-04', '2021-05'],
    'data' => [
        [
            'name' => '新增客户',
            'data' => [mt_rand(100,999), mt_rand(100,999), mt_rand(100,999), mt_rand(100,999), mt_rand(100,999)],
        ], [
            'name' => '累计客户',
            'data' => [mt_rand(100,999), mt_rand(100,999), mt_rand(100,999), mt_rand(100,999), mt_rand(100,999)],
        ], [
            'name' => '有效客户',
            'data' => [mt_rand(100,999), mt_rand(100,999), mt_rand(100,999), mt_rand(100,999), mt_rand(100,999)],
        ]
    ]
], 'line', [], $chart);













function showDemo($title, $data, $method, $option, $chart)
{
    echo '<fieldset><legend>'.$title.'</legend>';
    echo $chart->$method($data, $option);
    echo '</fieldset>';
}

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
function faker($length, callable $callable) {
    $arr = [];
    for ($i = 1; $i <= $length; $i++) {
        $arr[] = $callable($i);
    }
    return $arr;
}