<?php

//演示网站：https://echarts.apache.org/examples/zh/index.html#chart-type-pie

namespace Webguosai;

use Hisune\EchartsPHP\ECharts;
use Webguosai\Helper\Arr;

class Chart
{
    protected $chart;

    public function __construct($dist = '//cdn.jsdelivr.net/npm/echarts/dist')
    {
        $this->chart = new ECharts($dist);
    }


    // 饼图
    // https://echarts.apache.org/examples/zh/editor.html?c=pie-simple
    public function pieSimple($data = [], $option = [], $height = '300px')
    {
        $default = [
            'tooltip' => [
                'trigger' => 'item',
            ],
            'legend'  => [
                'orient' => 'vertical',
                'left'   => 'left',
            ],
            'title'   => [
                'text'    => '',
                'subtext' => '',
                'left'    => 'center'
            ],
            'series'  => [
                [
                    'type'     => 'pie',
                    'radius'   => '50%',
                    'data'     => $data,
                    'emphasis' => [
                        'itemStyle' => [
                            'shadowBlur'    => 10,
                            'shadowOffsetX' => 0,
                            'shadowColor'   => 'rgba(0, 0, 0, 0.5)',
                        ],
                    ],
                ],
            ],
        ];

        return $this->render($default, $option, $height);
    }

    // https://echarts.apache.org/examples/zh/editor.html?c=pie-doughnut
    public function pieDoughnut($data = [], $option = [], $height = '300px')
    {
        $default = [
            'tooltip' => [
                'trigger' => 'item',
            ],
            'legend'  => [
                'top'  => '5%',
                'left' => 'center',
            ],
            'series'  => [
                [
                    'type'              => 'pie',
                    'radius'            => ['40%', '70%'],
                    'avoidLabelOverlap' => false,
                    'label'             => [
                        'show'     => false,
                        'position' => 'center',
                    ],
                    'emphasis'          => [
                        'label' => [
                            'show'       => true,
                            'fontSize'   => '20',
                            'fontWeight' => 'bold',
                        ],
                    ],
                    'labelLine'         => [
                        'show' => false,
                    ],
                    'data'              => $data,
                ],
            ],
        ];

        return $this->render($default, $option, $height);
    }

    //https://echarts.apache.org/examples/zh/editor.html?c=bar-tick-align
    public function barTickAlign($data = [], $option = [], $height = '300px')
    {
        $label = [];
        $data2 = [];
        foreach ($data as $value) {
            $label[] = $value['name'];
            $data2[] = $value['value'];
        }

        $default = [
            'tooltip' => [
                'trigger'     => 'axis',
                'axisPointer' => [
                    'type' => 'shadow',
                ],
            ],
            'grid'    => [
                'left'         => '3%',
                'right'        => '4%',
                'bottom'       => '3%',
                'containLabel' => true,
            ],
            'xAxis'   => [
                [
                    'type'     => 'category',
                    'data'     => $label,
                    'axisTick' => [
                        'alignWithLabel' => true,
                    ],
                ],
            ],
            'yAxis'   => [
                [
                    'type' => 'value',
                ],
            ],
            'series'  => [
                [
                    'type'     => 'bar',
                    'label'    => [
                        'show'     => true,
                        'position' => 'top',
                    ],
                    'barWidth' => '60%',
                    'data'     => $data2,
                ],
            ],
        ];

        return $this->render($default, $option, $height);
    }

    //https://echarts.apache.org/examples/zh/editor.html?c=dataset-simple0
    public function barDatasetSimple0($data = [], $option = [], $height = '300px')
    {
        $default = [
            'tooltip' => [
                'trigger'     => 'axis',
                'axisPointer' => [
                    'type' => 'shadow',
                ],
            ],
            'dataset' => [
                'source' => [
                    [
                        '',
                        '2020',
                        '2021',
                        '2022'
                    ],
                    [
                        '项目1',
                        43.3,
                        85.8,
                        93.7,
                    ],
                    [
                        '项目2',
                        83.1,
                        73.4,
                        55.1,
                    ],
                    [
                        '项目3',
                        86.4,
                        65.2,
                        82.5,
                    ],
                    [
                        '项目4',
                        72.4,
                        53.9,
                        39.1,
                    ],
                ],
            ],
            'xAxis' => [
                'type' => 'category',
            ],
            'yAxis' => [
                'gridIndex' => 0
            ],
            'series' => [
                [
                    'type' => 'bar',
                    'label'    => [
                        'show'     => true,
                        'position' => 'top',
                    ],
                    'showBackground'  => true,
                ],
                [
                    'type' => 'bar',
                    'label'    => [
                        'show'     => true,
                        'position' => 'top',
                    ],
                    'showBackground'  => true,
                ],
                [
                    'type' => 'bar',
                    'label'    => [
                        'show'     => true,
                        'position' => 'top',
                    ],
                    'showBackground'  => true,
                ],
            ],
        ];

        return $this->render($default, $option, $height);
    }

    // 折线图
    // https://echarts.apache.org/examples/zh/index.html#chart-type-line
    public function line($data = [], $option = [], $height = '300px')
    {
        $legend = [];
        $labels = [];
        $series = [];

//        $legend = [
//            'Email',
//            'Union Ads',
//            'Video Ads',
//            'Direct',
//            'Search Engine',
//        ];
//
//        $labels = [
//            'Mon',
//            'Tue',
//            'Wed',
//            'Thu',
//            'Fri',
//            'Sat',
//            'Sun',
//        ];

        foreach ($data as $value) {
            $legend[] = $value['name'];
            $label[] = $value['name'];
            $series[] = [
                'name' => $value['name'],
                'type' => 'line',
                'stack' => 'Total',
                'data' => $value['data'],
            ];
        }
        dump($legend);
        //dump($series);

        $default = [
            'tooltip' => [
                'trigger' => 'axis',
//                'axisPointer' => [
//                    'type' => 'shadow',
//                ],
            ],
            'legend' => [
                'data' => $legend,
            ],
            'grid' => [
                'left' => '2%',
                'right' => '2%',
                'bottom' => '3%',
                'containLabel' => true,
            ],
//            'toolbox' => [
//                'feature' => [
//                    'saveAsImage' => [
//                    ],
//                ],
//            ],
            'xAxis' => [
                'type' => 'category',
                'boundaryGap' => false,
                'data' => $labels,
            ],
            'yAxis' => [
                'type' => 'value',
            ],
            'ser1ies' => $series,
            'series' => [
                [
                    'name' => 'Email',
                    'type' => 'line',
                    'stack' => 'Total',
                    'data' => [
                        120,
                        132,
                        101,
                        134,
                        90,
                        230,
                        210,
                    ],
                ],
                [
                    'name' => 'Union Ads',
                    'type' => 'line',
                    'stack' => 'Total',
                    'data' => [
                        220,
                        182,
                        191,
                        234,
                        290,
                        330,
                        310,
                    ],
                ],
                [
                    'name' => 'Video Ads',
                    'type' => 'line',
                    'stack' => 'Total',
                    'data' => [
                        150,
                        232,
                        201,
                        154,
                        190,
                        330,
                        410,
                    ],
                ],
                [
                    'name' => 'Direct',
                    'type' => 'line',
                    'stack' => 'Total',
                    'data' => [
                        320,
                        332,
                        301,
                        334,
                        390,
                        330,
                        320,
                    ],
                ],
                [
                    'name' => 'Search Engine',
                    'type' => 'line',
                    'stack' => 'Total',
                    'data' => [
                        820,
                        932,
                        901,
                        934,
                        1290,
                        1330,
                        1320,
                    ],
                ],
            ],
        ];

        return $this->render($default, $option, $height);
    }


    // 渲染
    protected function render($default, $option, $height)
    {
        $option = Arr::merge($default, $option);

        $this->chart->_options = [];
        $this->chart->setOption($option);

        return $this->chart->render('id_' . uniqid(), ['style' => 'height: ' . $height . ';']);
    }
}