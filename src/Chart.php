<?php

//演示网站：https://echarts.apache.org/examples/zh/index.html#chart-type-pie

namespace Webguosai;

use Hisune\EchartsPHP\ECharts;

class Chart
{
    protected $chart;

    public function __construct()
    {
        $this->chart = new ECharts();
    }

    // 饼图
    // https://echarts.apache.org/examples/zh/editor.html?c=pie-simple
    public function pieSimple($id, $data = [], $title = [], $height = 300)
    {
        $title = array_merge(['left' => 'center'], $title);

        $option = [
            'tooltip' => [
                'trigger' => 'item',
            ],
            'legend'  => [
                'orient' => 'vertical',
                'left'   => 'left',
            ],
            'title'   => $title,
            'series'  => [
                [
                    //'name' => 'Access From',
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
        $this->chart->_options = [];
        $this->chart->setOption($option);

        return $this->chart->render($id, ['style' => 'height: ' . $height . 'px;']);
    }

    // https://echarts.apache.org/examples/zh/editor.html?c=pie-doughnut
    public function pieDoughnut($id, $data = [], $height = 300)
    {
        $option = [
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

        $this->chart->_options = [];
        $this->chart->setOption($option);

        return $this->chart->render($id, ['style' => 'height: ' . $height . 'px;']);
    }

    //柱状图
    //https://echarts.apache.org/examples/zh/editor.html?c=bar-background
    public function barBackground($id, $data = [], $height = 300)
    {
        $data1 = [];
        $data2 = [];
        foreach ($data as $value) {
            $data1[] = $value['name'];
            $data2[] = $value['value'];
        }

        $option = [
            'xAxis' => [
                'type' => 'category',
                'data' => $data1,
            ],
            'yAxis' => [
                'type' => 'value',
            ],
            'series' => [
                [
                    'data' => $data2,
                    'type' => 'bar',
                    'showBackground' => true,
                    'backgroundStyle' => [
                        'color' => 'rgba(180, 180, 180, 0.2)',
                    ],
                ],
            ],
        ];

        $this->chart->_options = [];
        $this->chart->setOption($option);

        return $this->chart->render($id, ['style' => 'height: ' . $height . 'px;']);
    }

}