<?php

/**
 * 携趣网络
 *
 * 官网：https://www.xiequ.cn/redirect.aspx?act=MyWork.aspx?act=test
 * 提取地址：https://www.xiequ.cn/redirect.aspx?act=GetIp.aspx
 *
 * 帐号：a18230558327
 * 密码：a277428363
 */

namespace Webguosai\HttpAgentIp;

use Webguosai\Helper\Arr;
use Webguosai\HttpClient;

class Xq
{
    protected $config = [
        'uid'  => '',
        'ukey' => '',//在绑定白名单时需要
        'vkey' => '',//在获取代理ip时需要
    ];
    protected $client;

    public function __construct($config = [])
    {
        $this->config = $config;
        $this->client = new HttpClient([
            'timeout' => 3,
        ]);
    }

    /**
     * 绑定白名单
     *
     * @param $ip
     * @return array
     * @throws \Exception
     */
    public function bindWhiteList($ip)
    {
        $url = 'http://op.xiequ.cn/IpWhiteList.aspx';

        $data = [
            'act' => 'add',
            'ip'  => $ip,
        ];

        return $this->request($url, $data);
    }

    /**
     * 获取代理ip
     *
     * @param int $num 数量
     * @param string $address 地区(留空为全国)
     * @return array
     * @throws \Exception
     */
    public function get($num = 5, $address = '')
    {
        $url = 'http://api.xiequ.cn/VAD/GetIp.aspx';

        $data = [
            'act'  => 'get',
            'num'  => $num,
            'time' => 30,
            'plat' => 0,
            're'   => 0,
            'type' => 0,
            'so'   => 1,
            'ow'   => 1,
            'spl'  => 1,
            'addr' => $address,
            'db'   => 1,
        ];

        return $this->request($url, $data);
    }

    protected function request(string $url, array $data = [])
    {
        $data = Arr::merge($this->config, $data);

        $response = $this->client->get($url, $data);

        if ($response->ok()) {
            $json = $response->json();

            if ($json) {
                if ($json['code'] === 0) {
                    return $this->handleFormat($json['data']);
                }

                throw new \Exception($json['msg']);
            } else {
                return $response->body;
            }
        }

        throw new \Exception($response->getErrorMsg());
    }

    /**
     * 处理格式
     *
     * @param array $data
     * @return array
     */
    protected function handleFormat(array $data)
    {
        $new = [];
        foreach ($data as $value) {
            $new[] = $value['IP'] . ':' . $value['Port'];
        }
        return $new;
    }

}