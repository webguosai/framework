<?php

//演示网站：https://echarts.apache.org/examples/zh/index.html#chart-type-pie

namespace Webguosai;

use Hisune\EchartsPHP\ECharts;
use Webguosai\Helper\Arr;

class Chart
{
    protected $chart;

    public function __construct($dist = '//cdn.jsdelivr.net/npm/echarts/dist')
    //public function __construct($dist = '//lib.baomitu.com/echarts/4.2.1')
    {
        $this->chart = new ECharts($dist);
    }

    /**
     * 柱状图
     * https://echarts.apache.org/examples/zh/index.html#chart-type-bar
     *
     * @param array $data
     * @param array $option
     * @param string $height
     * @return string
     */
    public function bar($data = [], $option = [], $height = '300px')
    {
        $labels = $data['name'];
        $legend = [];
        $series = [];

        foreach ($data['data'] as $value) {
            $legend[] = $value['name'];
            $series[] = [
                'name' => $value['name'],
                'type' => 'bar',
                'label'    => [
                    'show'     => true,
                    'position' => 'top',
                ],
                'data' => $value['data'],
            ];
        }

        $default = [
            'tooltip' => [
                'trigger' => 'axis',
                'axisPointer' => [
                    'type' => 'shadow',//cross
                ],

            ],
            'legend' => [
                'data' => $legend,
            ],
            'grid' => [
                'left'         => '2%',
                'right'        => '2%',
                'bottom'       => '3%',
                'containLabel' => true,
            ],
            'xAxis' => [
                [
                    'type' => 'category',
                    'data' => $labels,
                ],
            ],
            'yAxis' => [
                [
                    'type' => 'value',
                ],
            ],
            'series' => $series,
        ];

        return $this->render($default, $option, $height);
    }

    /**
     * 折线图
     * https://echarts.apache.org/examples/zh/index.html#chart-type-line
     *
     * @param array $data
     * @param array $option
     * @param string $height
     * @return string
     */
    public function line($data = [], $option = [], $height = '300px')
    {
        $labels = $data['name'];
        $legend = [];
        $series = [];

        foreach ($data['data'] as $value) {
            $legend[] = $value['name'];
            $series[] = [
                'name'  => $value['name'],
                'type'  => 'line',
                'stack' => 'Total',
                'label'    => [
                    'show'     => true,
                    'position' => 'top',
                ],
                'data'  => $value['data'],
            ];
        }
        $default = [
            'tooltip' => [
                'trigger' => 'axis',
            ],
            'legend' => [
                'data' => $legend,
            ],
            'grid' => [
                'left'         => '2%',
                'right'        => '2%',
                'bottom'       => '3%',
                'containLabel' => true,
            ],
            'xAxis' => [
                'type'        => 'category',
                'boundaryGap' => false,
                'data'        => $labels,
            ],
            'yAxis' => [
                'type' => 'value',
            ],
            'series' => $series,
        ];

        return $this->render($default, $option, $height);
    }

    /**
     * 饼图
     * https://echarts.apache.org/examples/zh/index.html#chart-type-pie
     *
     * @param array $data
     * @param array $option
     * @param string $height
     * @return string
     */
    public function pie($data = [], $option = [], $height = '300px')
    {
        $default = [
            'tooltip' => [
                'trigger' => 'item',
                'formatter' => '{b} : {c} ({d}%)',
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
//                    'radius' => ['70%', '40%'],
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

    // 漏斗
    public function funnel($data = [], $option = [], $height = '300px')
    {
        foreach ($data as $value) {
            $legend[] = $value['name'];
        }

        $default = [
            'tooltip' => [
                'trigger' => 'item',
            ],
            'legend' => [
                'data' => $legend,
            ],
            'calculable' => true,
            'series' => [
                'type' => 'funnel',
                'left' => '10%',
                'top' => 60,
                'bottom' => 60,
                'width' => '80%',
                'min' => 0,
                'max' => 100,
                'minSize' => '0%',
                'maxSize' => '100%',
                'sort' => 'descending',
                'gap' => 2,
                'label' => [
                    'show' => true,
                    'position' => 'inside',
                ],
                'labelLine' => [
                    'length' => 10,
                    'lineStyle' => [
                        'width' => 1,
                        'type' => 'solid',
                    ],
                ],
                'itemStyle' => [
                    'borderColor' => '#fff',
                    'borderWidth' => 1,
                ],
                'emphasis' => [
                    'label' => [
                        'fontSize' => 20,
                    ],
                ],
                'data' => $data
            ],
        ];

        return $this->render($default, $option, $height);
    }

    /**
     * 渲染
     *
     * @param array $default
     * @param array $option
     * @param string $height
     * @return string
     */
    protected function render(array $default, array $option, $height)
    {
        $option = Arr::merge($default, $option);

        $this->chart->_options = [];
        $this->chart->setOption($option);

        return $this->chart->render('id_' . uniqid(), ['style' => 'height: ' . $height . ';']);
    }
}