<?php

namespace Webguosai\Util;

use Exception;

/**
 * 概率抽奖类
 */
class Lottery
{
    /**
     * 初始化标志
     *
     * @var boolean
     */
    protected $init = false;

    /**
     * 奖品列表
     *
     * @var array
     */
    protected $awards = [];

    /**
     * 概率总和
     *
     * @var integer
     */
    protected $probabilityCount = 100;

    /**
     * 奖品概率索引
     *
     * @var string
     */
    protected $probabilityKey = 'probability';

    /**
     * 支持概率的小数位数
     *
     * @var integer
     */
    protected $scale = 4;

    /**
     * 初始化
     *
     * @param array $awards 奖品列表
     * @param string $probabilityKey 奖品概率索引
     * @param string $notWin 未中奖信息
     * @param integer $scale 支持概率的小数位数
     * @param integer $probabilityCount 概率总和
     * @throws Exception
     * @return Lottery
     */
    public function init(array $awards, $probabilityKey = 'probability', $notWin = '抱歉，您未中奖', $scale = 4, $probabilityCount = 100)
    {
        $this->awards = $awards;
        $this->probabilityKey = $probabilityKey;
        $this->scale = $scale;
        $this->probabilityCount = $probabilityCount;
        // 计算奖品总概率
        $probabilityCount = 0;
        foreach ($this->awards as &$item) {
            $probabilityCount = bcadd($probabilityCount, $item[$this->probabilityKey], $this->scale);
            // 标记中奖
            $item['isWin'] = true;
        }
        if (bccomp($probabilityCount, $this->probabilityCount, $this->scale) > 0) {
            throw new Exception('概率总和必须小于等于概率总和(' . $this->probabilityCount . ')，当前总和为：' . $probabilityCount);
        }
        // 未中奖奖项
        $notAward = [
            'title' => $notWin,
            'isWin' => false,
            $this->probabilityKey => bcsub($this->probabilityCount, $probabilityCount, $this->scale)
        ];
        $this->awards[] = $notAward;
        // 打乱顺序
        shuffle($this->awards);
        $this->init = true;
        return $this;
    }

    /**
     * 采用经典概率算法进行抽奖
     *
     * @throws Exception
     * @return array 返回数据中，isWin为true则表示中奖
     */
    public function getDraw()
    {
        if (!$this->init) {
            throw new Exception('未初始化抽奖配置');
        }
        $probabilityCount = $this->probabilityCount;
        $pow = pow(10, $this->scale);
        foreach ($this->awards as $item) {
            $randProbability = $probabilityCount * $pow;
            $randInum = mt_rand(1, $randProbability);
            $randNum = bcdiv($randInum, $pow, $this->scale);
            $bccomp = bccomp($randNum, $item[$this->probabilityKey], $this->scale);
            if ($bccomp == 0 || $bccomp == -1) {
                return $item;
            }
            $probabilityCount = bcsub($probabilityCount, $item[$this->probabilityKey], $this->scale);
        }

        throw new Exception('抽奖失败，未抽到奖品');
    }

    /**
     * 获取奖品列表
     *
     * @return array
     */
    public function getAwards()
    {
        return $this->awards;
    }
}
