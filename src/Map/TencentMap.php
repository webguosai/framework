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
     * @param string|double $lat 纬度：39.984154
     * @param string|double $lng 经度：116.307490
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws \Exception
     */
    public function geoLocation($lat, $lng, $extraParams = [])
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
    public function geoAddress(string $address, $extraParams = [])
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
    public function geoSmartAddress(string $smartAddress, $extraParams = [])
    {
        $extraParams['smart_address'] = $smartAddress;
        return $this->request('/ws/geocoder/v1/', $extraParams);
    }

    /**
     * 驾车规划
     * https://lbs.qq.com/service/webService/webServiceGuide/webServiceRoute#2
     *
     * @param string|double $fromLat 起点纬度
     * @param string|double $fromLng 起点经度
     * @param string|double $toLat 终点纬度
     * @param string|double $toLng 终点经度
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws \Exception
     */
    public function dirDriving($fromLat, $fromLng, $toLat, $toLng, $extraParams = [])
    {
        $extraParams['get_mp'] = 1; //返回多个方案
        return $this->direction('driving', $fromLat, $fromLng, $toLat, $toLng, $extraParams);
    }

    /**
     * 公交规划
     * https://lbs.qq.com/service/webService/webServiceGuide/webServiceRoute#5
     *
     * @param string|double $fromLat 起点纬度
     * @param string|double $fromLng 起点经度
     * @param string|double $toLat 终点纬度
     * @param string|double $toLng 终点经度
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws \Exception
     */
    public function dirTransit($fromLat, $fromLng, $toLat, $toLng, $extraParams = [])
    {
        return $this->direction('transit', $fromLat, $fromLng, $toLat, $toLng, $extraParams);
    }

    /**
     * 步行规划
     * https://lbs.qq.com/service/webService/webServiceGuide/webServiceRoute#3
     *
     * @param string|double $fromLat 起点纬度
     * @param string|double $fromLng 起点经度
     * @param string|double $toLat 终点纬度
     * @param string|double $toLng 终点经度
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws \Exception
     */
    public function dirWalking($fromLat, $fromLng, $toLat, $toLng, $extraParams = [])
    {
        return $this->direction('walking', $fromLat, $fromLng, $toLat, $toLng, $extraParams);
    }

    /**
     * 骑行规划
     * https://lbs.qq.com/service/webService/webServiceGuide/webServiceRoute#4
     *
     * @param string|double $fromLat 起点纬度
     * @param string|double $fromLng 起点经度
     * @param string|double $toLat 终点纬度
     * @param string|double $toLng 终点经度
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws \Exception
     */
    public function dirBicycling($fromLat, $fromLng, $toLat, $toLng, $extraParams = [])
    {
        return $this->direction('bicycling', $fromLat, $fromLng, $toLat, $toLng, $extraParams);
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
    public function staticMap($size = '500*500', $extraParams = [])
    {
        $extraParams['size'] = $size;
        return $this->request('/ws/staticmap/v2/', $extraParams);
    }

    /**
     * ip定位
     * https://lbs.qq.com/service/webService/webServiceGuide/webServiceIp
     *
     * @param string $ip
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws \Exception
     */
    public function ip($ip, $extraParams = [])
    {
        $extraParams['ip'] = $ip;
        return $this->request('/ws/location/v1/ip/', $extraParams);
    }

    /**
     * 获取省市区列表
     * https://lbs.qq.com/service/webService/webServiceGuide/webServiceDistrict#2
     *
     * @param array $extraParams
     * @return mixed
     * @throws \Exception
     */
    public function regions($extraParams = [])
    {
        return $this->request('/ws/district/v1/list', $extraParams);
    }

    /**
     * 封装的规划方向
     * https://lbs.qq.com/service/webService/webServiceGuide/webServiceRoute
     *
     * @param string $direction 规划方式：驾车(driving) 步行(walking) 骑行(bicycling) 公交(transit)
     * @param string|double $fromLat 起点纬度
     * @param string|double $fromLng 起点经度
     * @param string|double $toLat 终点纬度
     * @param string|double $toLng 终点经度
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws \Exception
     */
    protected function direction($direction, $fromLat, $fromLng, $toLat, $toLng, $extraParams = [])
    {
        $extraParams['from'] = $fromLat . ',' . $fromLng;
        $extraParams['to']   = $toLat . ',' . $toLng;
        return $this->request('/ws/direction/v1/' . $direction . '/', $extraParams);
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
        $params['key']    = $this->key;

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