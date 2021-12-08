<?php
/**
 * 阶梯
 */

namespace Webguosai;

use Webguosai\Helper\Arr;

class Step
{
    protected $steps = [];
    protected $rangeField = '';
    protected $descField = '';

    /**
     * 初始化
     *
     * @param array $steps 阶梯数据
     * @param string $rangeField 范围字段名
     * @param string $descField 描述字段名
     */
    public function __construct($steps = [], $rangeField = 'range', $descField = 'desc')
    {
        $this->rangeField = $rangeField;
        $this->descField  = $descField;

        $this->steps = $this->sort($steps);
    }

    /**
     * 获取对应阶梯的数组信息
     *
     * @param string|int $range
     * @param null $field
     * @return array
     */
    public function get($range = 0, $field = null)
    {
        $get = [];
        foreach ($this->steps as $level) {
            if ($range <= $level[$this->rangeField] || Arr::isLast($this->steps, $level)) {
                $get = $level;
                break;
            }
        }

        if ($field !== null && isset($get[$field])) {
            $get = $get[$field];
        }

        return $get;
    }

    /**
     * 获取
     *
     * @param string|int $range 范围值
     * @return array
     */
    public function getName($range = 0)
    {
        return $this->get($range, 'name');
    }

    /**
     * 获取所有阶梯数据
     *
     * @return array
     */
    public function all()
    {
        return $this->steps;
    }

    /**
     * 根据排序字段按从小到大排序
     *
     * @param $steps
     * @return array
     */
    protected function sort($steps)
    {
        // 排序
        usort($steps, function ($a, $b) {
            $f1 = $a[$this->rangeField];
            $f2 = $b[$this->rangeField];
            if ($f1 == '-' || empty($f1)) return 1;
            if ($f2 == '-' || empty($f2)) return -1;
            if ($f1 == $f2) return 0;
            return ($f1 < $f2) ? -1 : 1;
        });

        // 增加描述字段
        $min = 0;
        foreach ($steps as $key => $step) {
            if (Arr::isLast($steps, $step)) {
                $desc = $min . ' ~ ';
            } else {
                $max  = $step[$this->rangeField];
                $desc = $min . ' - ' . $max;
                $min  = $max + 1;
            }
            $steps[$key][$this->descField] = $desc;
        }

        return $steps;
    }

}


require_once '../vendor/autoload.php';
$points = [
    [
        'level' => 'L1',
        'name'  => '筑基学徒',
        'point' => '4000',
        'pic'   => 'https://cdn.hnsy17.com/upload/2021-12-08/3ba21be311c5fa492a11416a6ddf76ad.png',//等级背景图
    ], [
        'level' => 'L2',
        'name'  => '安全里手',
        'point' => '9000',
        'pic'   => 'https://cdn.hnsy17.com/upload/2021-12-08/72c718d6cd5902279751ee38638fcc0f.png',//等级背景图
    ], [
        'level' => 'L3',
        'name'  => '资深专家',
        'point' => '15000',
        'pic'   => 'https://cdn.hnsy17.com/upload/2021-12-08/26fcd7c8ecbe93a66f0f55acdcd8ed0c.png',//等级背景图
    ], [
        'level' => 'L4',
        'name'  => '一代宗师',
        'point' => '20000',
        'pic'   => 'https://cdn.hnsy17.com/upload/2021-12-08/504f2754ab04e5dccd0ae5a9ba7a9cfe.png',//等级背景图
    ], [
        'level' => 'L5',
        'name'  => '大神传说',
        'point' => '-',
        'pic'   => 'https://cdn.hnsy17.com/upload/2021-12-08/addb81462cd8905a1f11da0e752b2020.png',//等级背景图
    ]
];;

$step = new Step($points, 'point');
var_dump($step->get('24999'));
//var_dump($step->all());