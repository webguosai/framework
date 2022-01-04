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
    public function pie($id, $data = [], $height = 500)
    {
        $option = [
            'title'   => [
                'text'    => '标题',
                'subtext' => '描述',
                'left'    => 'center',
            ],
            'tooltip' => [
                'trigger' => 'item',
            ],
            'legend'  => [
                'orient' => 'vertical',
                'left'   => 'left',
            ],
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
        $this->chart->setOption($option);

        return $this->chart->render($id, ['style' => 'height: '.$height.'px;']);
    }


    /**
     * 柱状图(未测试)
     * @return string
     */
    public function bar()
    {
        $this->chart->tooltip->show = true;
        $this->chart->legend->data[] = '销量';
        $this->chart->xAxis[] = array(
            'type' => 'category',
            'data' => array("衬衫","羊毛衫","雪纺衫","裤子","高跟鞋","袜子")
        );
        $this->chart->yAxis[] = array(
            'type' => 'value'
        );
        $this->chart->series[] = array(
            'name' => '销量',
            'type' => 'bar',
            'data' => array(5, 20, 40, 10, 10, 20)
        );
        return $this->chart->render('simple-custom-id');
    }

}