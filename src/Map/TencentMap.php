<?php
/**
 * 腾讯地图
 * 文档：https://lbs.qq.com/service/webService/webServiceGuide/webServiceGcoder
 * key申请：https://lbs.qq.com/dev/console/application/mine
 */
namespace Webguosai\Map;

use Webguosai\Helper\Arr;
use Webguosai\HttpClient;

class TencentMap
{
    protected $key = '';
    protected $host = 'https://apis.map.qq.com';

    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * 坐标转地址
     * https://lbs.qq.com/service/webService/webServiceGuide/webServiceGcoder
     *
     * @param string|float $lat 纬度：39.984154
     * @param string|float $lng 经度：116.307490
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws \Exception
     */
    public function geocoderLocation($lat, $lng, $extraParams = [])
    {
        $extraParams['location'] = "{$lat},{$lng}";
        return $this->request('/ws/geocoder/v1/', $extraParams);
    }

    /**
     * 地址转坐标
     * https://lbs.qq.com/service/webService/webServiceGuide/webServiceGeocoder
     *
     * @param string $address 地址：湖南省长沙市
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws \Exception
     */
    public function geocoderAddress(string $address, $extraParams = [])
    {
        $extraParams['address'] = $address;
        return $this->request('/ws/geocoder/v1/', $extraParams);
    }

    /**
     * 智能地址解析(适用于收货地址)
     * https://lbs.qq.com/service/webService/webServiceGuide/SmartGeocoder
     *
     * @param string $smartAddress 详细地址：北京市海淀区彩和坊路海淀西大街74号
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws \Exception
     */
    public function geocoderSmartAddress(string $smartAddress, $extraParams = [])
    {
        $extraParams['smart_address'] = $smartAddress;
        return $this->request('/ws/geocoder/v1/', $extraParams);
    }

    /**
     * 静态图
     * https://lbs.qq.com/service/staticV2/staticGuide/staticDoc
     *
     * @param string $size 图片尺寸(单位：像素)
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws \Exception
     */
    public function getStaticMap($size = '500*500', $extraParams = [])
    {
        $extraParams['size'] = $size;
        return $this->request('/ws/staticmap/v2/', $extraParams);
    }

    //规划
    public function direction($from, $to, $extraParams = [])
    {
        $extraParams['from'] = $from;
        $extraParams['to'] = $to;
        $extraParams['get_mp'] = 1; //返回多个方案
        return $this->request('/ws/direction/v1/driving/', $extraParams);
    }

    /**
     * 封装的请求
     *
     * @param string $url
     * @param array $params
     * @return mixed
     * @throws \Exception
     */
    protected function request(string $url, $params = [])
    {
        $params['output'] = 'json';
        $params['key'] = $this->key;

        $url = $this->host . $url . '?' . http_build_query($params);

        $client   = new HttpClient();
        $response = $client->get($url);

        if ($response->ok()) {

            //如果为图片，直接返回
            if ($response->isImg()) {
                return $response->body;
            }

            $data = $response->json();

            if ($data['status'] === 0) {
                return $data['result'];
            }

            throw new \Exception($data['message']);
        }

        throw new \Exception($response->getErrorMsg());
    }
}