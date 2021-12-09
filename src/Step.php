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

        $this->steps = $this->handleSteps($steps);
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
        foreach ($this->steps as $step) {
            if ($range <= $step[$this->rangeField] || Arr::isLast($this->steps, $step)) {
                $get = $step;
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
     * 处理
     *
     * @param array $steps
     * @return array
     */
    protected function handleSteps($steps = [])
    {
        $steps = $this->checkEmpty($steps);

        // 排序
        $steps = $this->sort($steps);

        // 附加描述字段
        $steps = $this->appendDesc($steps);

        return $steps;
    }

    protected function checkEmpty($steps)
    {
        if (empty($steps)) {
            //throw new \Exception('请指定一组数据');
            $steps = [
                [
                    'name' => '没有数据',
                    $this->rangeField => '-',
                ]
            ];
            //var_dump($steps);
        }
        return $steps;
    }

    /**
     * 附加描述信息
     *
     * @param array $steps
     * @return array
     */
    protected function appendDesc($steps = [])
    {
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

    /**
     * 排序
     *
     * @param array $steps
     * @return array
     */
    protected function sort($steps = [])
    {
        usort($steps, function ($a, $b) {
            $f1 = $a[$this->rangeField];
            $f2 = $b[$this->rangeField];
            if ($f1 == '-' || empty($f1)) return 1;
            if ($f2 == '-' || empty($f2)) return -1;
            if ($f1 == $f2) return 0;
            return ($f1 < $f2) ? -1 : 1;
        });
        return $steps;
    }
}


require_once '../vendor/autoload.php';
$points = [
    [
        'point' => '4000',
        'level' => 'L1',
        'name'  => '筑基学徒',
        'pic'   => 'https://cdn.hnsy17.com/upload/2021-12-09/cf0acbf3bc6c3e555fc319226a714468.png',
    ], [
        'point' => '9000',
        'level' => 'L2',
        'name'  => '安全里手',
        'pic'   => 'https://cdn.hnsy17.com/upload/2021-12-09/bd4d6eb751d06c60deb7d4778ffdaf6a.png',
    ], [
        'point' => '15000',
        'level' => 'L3',
        'name'  => '资深专家',
        'pic'   => 'https://cdn.hnsy17.com/upload/2021-12-09/c2aab1fff86a83a47d3c104c3261a387.png',
    ], [
        'point' => '20000',
        'level' => 'L4',
        'name'  => '一代宗师',
        'pic'   => 'https://cdn.hnsy17.com/upload/2021-12-09/872db0c0c5c8837f180aa57c1467dc15.png',
    ], [
        'point' => '-',
        'level' => 'L5',
        'name'  => '大神传说',
        'pic'   => 'https://cdn.hnsy17.com/upload/2021-12-09/b07fa1f2b3465086053a8bff79c32835.png',
    ]
];
$points = [];
$step   = new Step($points, 'point');
var_dump($step->get('24999'));
var_dump($step->getName('24999'));
//var_dump($step->all());