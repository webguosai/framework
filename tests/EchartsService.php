<?php

namespace app\tools\service;

use Hisune\EchartsPHP\ECharts;

/**
 * Echarts图标生成
 */
class EchartsService extends \app\base\service\BaseService {

    /**
     * 饼图
     * @param $id
     * @param $name
     * @param $data
     * @param $height
     * @param bool $numShow
     * @return string
     */
    public function pie($id, $name, $data, $height, $numShow = true) {
        $chart = new ECharts('//lib.baomitu.com/echarts/4.2.1');
        $label = [];
        foreach ($data as $vo) {
            $label[] = $vo['name'];
        }
        $option = [
            'tooltip' => [
                'trigger' => 'item',
                'formatter' => $numShow ? "{a} <br/>{b} : {c} ({d}%)" : "{a} <br/>{b} {d}%",
            ],
            'legend' => [
                'orient' => 'vertical',
                'left' => 'right',
                'data' => $label,
            ],
            'series' => [
                'name' => $name,
                'type' => 'pie',
                'radius' => '55%',
                'center' => ['40%', '50%'],
                'data' => $data,
                'itemStyle' => [
                    'emphasis' => [
                        'shadowBlur' => 10,
                        'shadowOffsetX' => 0,
                        'shadowColor' => 'rgba(0, 0, 0, 0.5)',
                    ],
                ],
            ],
        ];
        $chart->setOption($option);
        $chart->setJsVar($id);
        \Hisune\EchartsPHP\Config::addExtraScript('style.js', ROOT_URL . '/public/common/js/package/echats/');
        return $chart->render($id, ['style' => 'height: ' . $height . 'px'], 'walden');
    }

    /**
     * 环形图
     * @param $id
     * @param $name
     * @param $data
     * @param $height
     * @param bool $numShow
     * @param array $config
     * @return string
     * @throws \Exception
     */
    public function ring($id, $name, $data, $height, $numShow = true, $config = []) {

        $chart = new ECharts('//lib.baomitu.com/echarts/4.2.1');

        $label = [];

        foreach ($data as $vo) {
            $label[] = $vo['name'];
        }

        $option = [
            'tooltip' => [
                'trigger' => 'item',
                'formatter' => $numShow ? "{a} " . $this->wrap . "{b} : {c} ({d}%)" : "{a} " . $this->wrap . "{b} {d}%",
            ],
            'legend' => [
                'x' => 'center',
                'y' => 'bottom',
                'orient' => 'vertical',
                'data' => $label,
            ],
            'series' => [
                'hoverAnimation' => false,
                'legendHoverLink' => false,
                'name' => $name,
                'type' => 'pie',
                'radius' => ['70%', '40%'],
                'center' => ['50%', '35%'],
                'label' => [
                    'show' => false,
                ],
                'avoidLabelOverlap' => false,
                'data' => $data,
            ],
        ];

        $option = array_merge($option, $config);
        $chart->setOption($option);
        $chart->setJsVar($id);
        \Hisune\EchartsPHP\Config::addExtraScript('style.js', ROOT_URL . '/public/common/js/package/echats/');
        return $chart->render($id, ['style' => 'height: ' . $height . 'px'], 'walden');
    }

    /**
     * 环比图
     * @param $name
     * @param $data
     * @param bool $numShow
     * @param array $config
     * @return array
     */
    public function ringRete($id, $name, $data, $height, $numShow = true, $config = []) {
        $chart = new ECharts('//lib.baomitu.com/echarts/4.2.1');
        $label = [];
        foreach ($data as $vo) {
            $label[] = $vo['name'];
        }

        $data[0]['label'] = [
            'normal' => [
                'formatter' => $name,
                'textStyle' => [
                    'color' => '#999',
                    'fontSize' => 14,
                    'padding' => [40, 0, 0, 0],
                ],
            ],
        ];
        $data[1]['label'] = [
            'normal' => [
                'formatter' => '{d}%',
                'textStyle' => [
                    'color' => '#1e87ef',
                    'fontSize' => 24,
                    'padding' => [0, 0, 15, 0],
                ],
            ],
        ];

        $option = [
            'tooltip' => [
                'trigger' => 'item',
                'formatter' => $numShow ? "{a} " . '<br/>' . "{b} : {c} ({d}%)" : "{a} " . '<br/>' . "{b} {d}%",
            ],
            'legend' => [
                'orient' => 'vertical',
                'left' => 'right',
                'data' => $label,
                'show' => false
            ],
            'series' => [
                'hoverAnimation' => false,
                'legendHoverLink' => false,
                'name' => $name,
                'type' => 'pie',
                'radius' => ['70%', '50%'],
                'center' => ['50%', '50%'],
                'label' => [
                    'normal' => [
                        'position' => 'center',
                    ],
                    'show' => false,
                ],
                'avoidLabelOverlap' => false,
                'data' => $data,
            ],
        ];
        $option = array_merge($option, $config);
        $chart->setOption($option);
        $chart->setJsVar($id);
        \Hisune\EchartsPHP\Config::addExtraScript('style.js', ROOT_URL . '/public/common/js/package/echats/');
        return $chart->render($id, ['style' => 'height: ' . $height . 'px;'], 'walden');
    }

    /**
     * 折线图
     * @param $id
     * @param $labels
     * @param $data
     * @param $height
     * @param array $config
     * @return string
     */
    public function line($id, $labels, $data, $height, $config = []) {
        $chart = new ECharts('//lib.baomitu.com/echarts/4.2.1');
        $label = [];
        $series = [];
        $legend = [];

        foreach ($data as $vo) {
            $legend[] = $vo['name'];
            $label[] = $vo['name'];
            $series[] = [
                'name' => $vo['name'],
                'type' => 'line',
                'data' => $vo['data'],
            ];
        }

        $option = [
            'tooltip' => [
                'trigger' => 'axis',
                'axisPointer' => [
                    'type' => 'shadow',
                ],
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
            'xAxis' => [
                'type' => 'category',
                'boundaryGap' => false,
                'data' => $labels
            ],
            'yAxis' => [
                'type' => 'value',
            ],
            'series' => $series
        ];
        $config = array_merge($option, $config);
        $chart->setOption($config);
        \Hisune\EchartsPHP\Config::addExtraScript('style.js', ROOT_URL . '/public/common/js/package/echats/');
        return $chart->render($id, ['style' => 'height: ' . $height . 'px'], 'walden');
    }

    /**
     * 柱状图
     * @param $id
     * @param $labels
     * @param $data
     * @param $height
     * @return string
     */
    public function bar($id, $labels, $data, $height) {
        $chart = new ECharts('//lib.baomitu.com/echarts/4.2.1');
        $label = [];
        $series = [];
        $legend = [];

        foreach ($data as $vo) {
            $legend[] = $vo['name'];
            $label[] = $vo['name'];
            $series[] = [
                'name' => $vo['name'],
                'type' => 'bar',
                'data' => $vo['data'],
            ];
        }

        $option = [
            'tooltip' => [
                'trigger' => 'axis',
                'axisPointer' => [
                    'type' => 'shadow',
                ],
            ],
            'legend' => [
                'data' => $legend,
            ],
            'grid' => [
                'left' => '3%',
                'right' => '4%',
                'bottom' => '3%',
                'containLabel' => true,
            ],
            'xAxis' => [
                'type' => 'category',
                'data' => $labels
            ],
            'yAxis' => [
                'type' => 'value',
            ],
            'series' => $series
        ];
        $chart->setOption($option);
        $chart->setJsVar($id);
        \Hisune\EchartsPHP\Config::addExtraScript('style.js', ROOT_URL . '/public/common/js/package/echats/');
        return $chart->render($id, ['style' => 'height: ' . $height . 'px'], 'walden');
    }

    /**
     * 堆叠图
     * @param $id
     * @param $name
     * @param $labels
     * @param $data
     * @param $height
     * @return string
     */
    public function pile($id, $name, $labels, $data, $height) {
        $chart = new ECharts('//lib.baomitu.com/echarts/4.2.1');
        $label = [];
        $series = [];
        $legend = [];

        foreach ($data as $vo) {
            $legend[] = $vo['name'];
            $label[] = $vo['name'];
            $series[] = [
                'name' => $vo['name'],
                'type' => 'bar',
                'stack' => $vo['stack'] ? $vo['stack'] : $name,
                'data' => $vo['data'],
            ];
        }

        $option = [
            'tooltip' => [
                'trigger' => 'axis',
                'axisPointer' => [
                    'type' => 'shadow',
                ],
            ],
            'legend' => [
                'data' => $legend,
            ],
            'grid' => [
                'left' => '3%',
                'right' => '4%',
                'bottom' => '3%',
                'containLabel' => true,
            ],
            'xAxis' => [
                'type' => 'category',
                'data' => $labels
            ],
            'yAxis' => [
                'type' => 'value',
            ],
            'series' => $series
        ];
        $chart->setOption($option);
        $chart->setJsVar($id);
        \Hisune\EchartsPHP\Config::addExtraScript('style.js', ROOT_URL . '/public/common/js/package/echats/');
        return $chart->render($id, ['style' => 'height: ' . $height . 'px'], 'walden');
    }

    /**
     * 嵌套图
     * @param $id
     * @param $name
     * @param $data
     * @param $height
     * @param bool $numShow
     * @return string
     */
    public function nested($id, $name, $data, $height, $numShow = true) {

        $chart = new ECharts('//lib.baomitu.com/echarts/4.2.1');

        $label = [];

        $typeData = [];
        foreach ($data as $vo) {
            $label[] = $vo['name'];
            $typeData[$vo['type']][] = $vo;
        }

        $option = [
            'tooltip' => [
                'trigger' => 'item',
                'formatter' => $numShow ? "{a} <br/>{b} : {c} ({d}%)" : "{a} <br/>{b} {d}%",
            ],
            'legend' => [
                'orient' => 'vertical',
                'left' => 'right',
                'data' => $label,
            ],
            'series' => [
                [
                    'name' => $name,
                    'type' => 'pie',
                    'selectedMode' => 'single',
                    'radius' => [0, '30%'],
                    'center' => ['40%', '50%'],
                    'data' => $typeData[0],
                    'label' => [
                        'normal' => [
                            'position' => 'inner',
                        ]
                    ],
                    'labelLine' => [
                        'normal' => [
                            'show' => false,
                        ]
                    ],
                    'itemStyle' => [
                        'emphasis' => [
                            'shadowBlur' => 10,
                            'shadowOffsetX' => 0,
                            'shadowColor' => 'rgba(0, 0, 0, 0.5)',
                        ],
                    ],
                ],
                [
                    'name' => $name,
                    'type' => 'pie',
                    'radius' => ['45%', '60%'],
                    'center' => ['40%', '50%'],
                    'data' => $typeData[1],
                    'itemStyle' => [
                        'emphasis' => [
                            'shadowBlur' => 10,
                            'shadowOffsetX' => 0,
                            'shadowColor' => 'rgba(0, 0, 0, 0.5)',
                        ],
                    ],
                ]
            ],
        ];
        $chart->setOption($option);
        $chart->setJsVar($id);
        \Hisune\EchartsPHP\Config::addExtraScript('style.js', ROOT_URL . '/public/common/js/package/echats/');
        return $chart->render($id, ['style' => 'height: ' . $height . 'px'], 'walden');
    }

    /**
     * 漏斗
     * @param $id
     * @param $name
     * @param $data
     * @param $height
     * @return string
     */
    public function funnel($id, $name, $data, $height) {
        $chart = new ECharts('//lib.baomitu.com/echarts/4.2.1');
        $label = [];
        foreach ($data as $vo) {
            $label[] = $vo['name'];
        }

        $option = [
            'tooltip' => [
                'trigger' => 'item',
                'formatter' => "{a} <br/>{b} : {c} ({d}%)",
            ],
            'legend' => [
                'data' => $label,
            ],
            'calculable' => true,
            'series' => [
                'name' => $name,
                'type' => 'funnel',
                'left' => '5%',
                'top' => 50,
                'bottom' => 0,
                'width' => '90%',
                'min' => 0,
                'max' => 100,
                'minSize' => '0%',
                'maxSize' => '100%',
                'sort' => 'descending',
                'gap' => 2,
                'label' => [
                    'normal' => [
                        'show' => true,
                        'position' => 'inside'
                    ],
                    'emphasis' => [
                        'textStyle' => [
                            'fontSize' => 20
                        ]
                    ]
                ],
                'labelLine' => [
                    'normal' => [
                        'length' => 10,
                        'lineStyle' => [
                            'width' => 1,
                            'type' => 'solid'
                        ]
                    ]
                ],
                'itemStyle' => [
                    'normal' => [
                        'borderColor' => '#fff',
                        'borderWidth' => 1
                    ]
                ],
                'data' => $data
            ],
        ];
        $chart->setOption($option);
        $chart->setJsVar($id);
        \Hisune\EchartsPHP\Config::addExtraScript('style.js', ROOT_URL . '/public/common/js/package/echats/');
        return $chart->render($id, ['style' => 'height: ' . $height . 'px'], 'walden');
    }

    public function map($id, $data, $height) {
        $chart = new ECharts('//lib.baomitu.com/echarts/4.2.1');
        $series = [];
        $legend = [];

        foreach ($data as $vo) {
            $legend[] = $vo['name'];
            $series[] = [
                'name' => $vo['name'],
                'type' => 'map',
                'geoIndex' => 0,
                'data' => $vo['data'],
            ];
        }

        $option = [
            'tooltip' => [
                'trigger' => 'item',
            ],
            'legend' => [
                'data' => $legend,
                'show' => false,
            ],
            'visualMap' => [
                'left' => 'left',
                'top' => 'top',
                'type' => 'piecewise',
                'orient' => 'horizontal',
                'text' => ['高', '低'],
                'calculable' => true
            ],
            'geo' => [
                'map' => 'china',
                'roam' => false,
                'zoom' => 1.23,
                'label' => [
                ],
                'itemStyle' => [
                    'normal' => [
                        'borderColor' => '#cccccc'
                    ],
                ],
            ],
            'series' => $series
        ];
        $chart->setOption($option);
        $chart->setJsVar($id);
        \Hisune\EchartsPHP\Config::addExtraScript('style.js', ROOT_URL . '/public/common/js/package/echats/');
        \Hisune\EchartsPHP\Config::addExtraScript('china.js', ROOT_URL . '/public/common/js/package/echats/js/');
        return $chart->render($id, ['style' => 'height: ' . $height . 'px'], 'walden');
    }

}

