<?php
/**
 * 阶梯
 */

namespace Webguosai\Util;

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

        if ($field !== null) {
            $get = '无数据';
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
//            $steps = [
//                [
//                    'name' => '没有数据',
//                    $this->rangeField => '-',
//                ]
//            ];
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