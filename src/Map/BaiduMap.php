<?php
/**
 * 百度地图
 * 文档：https://lbsyun.baidu.com/index.php?title=webapi/guide/webservice-geocoding
 * key申请：https://lbsyun.baidu.com/apiconsole/key?application=key#/home
 */

namespace Webguosai\Map;

class BaiduMap
{
    protected $config = [
        'ak' => '',
    ];

    protected $api = 'https://api.map.baidu.com';
    protected $version = 'v3';

    public function __construct($config = [])
    {
        $this->config = $config;
    }

//    public function geocoding($params)
//    {
//        return $this->request('geocoding', $params);
//    }

    public function __call($name, $arguments)
    {
        return $this->request($name, $arguments[0]);
    }

    protected function request($port, $params = [])
    {
        $params['ak']     = $this->config['ak'];
        $params['output'] = 'json';
        $url              = $this->api . '/' . $port . '/' . $this->version . '/?' . http_build_query($params);

        $client   = new \Webguosai\HttpClient();
        $response = $client->get($url);

        if ($response->ok()) {
            $data = $response->json();

            if ($data['status'] === 0) {
                return $data['result'];
            }

            throw new \Exception('状态码返回[' . $data['status'] . ']');
        }
        throw new \Exception($response->getErrorMsg());
    }
}