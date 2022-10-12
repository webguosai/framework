<?php
namespace Webguosai\Map;

use Webguosai\HttpClient;
use Exception;

/**
 * 百度地图
 * 文档：https://lbsyun.baidu.com/index.php?title=webapi/guide/webservice-geocoding
 * key申请：https://lbsyun.baidu.com/apiconsole/key?application=key#/home
 */
class BaiduMap
{
    protected $ak = '';
    protected $host = 'https://api.map.baidu.com';

    public function __construct($ak)
    {
        $this->ak = $ak;
    }

    /**
     * 地址转坐标
     * https://lbsyun.baidu.com/index.php?title=webapi/guide/webservice-geocoding
     *
     * @param string $address 地址：湖南省长沙市
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws Exception
     */
    public function geoAddress(string $address, $extraParams = [])
    {
        $extraParams['address'] = $address;
        return $this->request('/geocoding/v3/', $extraParams);
    }

    /**
     * 坐标转地址
     * https://lbsyun.baidu.com/index.php?title=webapi/guide/webservice-geocoding-abroad
     *
     * @param string|double $lat 纬度：39.984154
     * @param string|double $lng 经度：116.307490
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws Exception
     */
    public function geoLocation($lat, $lng, $extraParams = [])
    {
        $extraParams['location'] = "{$lat},{$lng}";
        return $this->request('/reverse_geocoding/v3/', $extraParams);
    }

    /**
     * 智能地址解析(适用于收货地址)(需要开通高级功能)
     * https://lbsyun.baidu.com/index.php?title=webapi/address_analyze
     *
     *
     * @param string $address 详细地址：北京市海淀区彩和坊路海淀西大街74号
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws Exception
     */
    public function geoSmartAddress(string $address, $extraParams = [])
    {
        $extraParams['address'] = $address;
        return $this->request('/address_analyzer/v1', $extraParams);
    }

    /**
     * 驾车规划(轻量)
     * https://lbsyun.baidu.com/index.php?title=webapi/directionlite-v1#service-page-anchor-1-0
     *
     * @param string|double $fromLat 起点纬度
     * @param string|double $fromLng 起点经度
     * @param string|double $toLat 终点纬度
     * @param string|double $toLng 终点经度
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws Exception
     */
    public function dirDriving($fromLat, $fromLng, $toLat, $toLng, $extraParams = [])
    {
        return $this->direction('driving', $fromLat, $fromLng, $toLat, $toLng, $extraParams);
    }

    /**
     * 公交规划(轻量)
     * https://lbsyun.baidu.com/index.php?title=webapi/directionlite-v1#service-page-anchor-1-3
     *
     * @param string|double $fromLat 起点纬度
     * @param string|double $fromLng 起点经度
     * @param string|double $toLat 终点纬度
     * @param string|double $toLng 终点经度
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws Exception
     */
    public function dirTransit($fromLat, $fromLng, $toLat, $toLng, $extraParams = [])
    {
        return $this->direction('transit', $fromLat, $fromLng, $toLat, $toLng, $extraParams);
    }

    /**
     * 步行规划(轻量)
     * https://lbsyun.baidu.com/index.php?title=webapi/directionlite-v1#service-page-anchor-1-2
     *
     * @param string|double $fromLat 起点纬度
     * @param string|double $fromLng 起点经度
     * @param string|double $toLat 终点纬度
     * @param string|double $toLng 终点经度
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws Exception
     */
    public function dirWalking($fromLat, $fromLng, $toLat, $toLng, $extraParams = [])
    {
        return $this->direction('walking', $fromLat, $fromLng, $toLat, $toLng, $extraParams);
    }

    /**
     * 骑行规划(轻量)
     * https://lbsyun.baidu.com/index.php?title=webapi/directionlite-v1#service-page-anchor-1-1
     *
     * @param string|double $fromLat 起点纬度
     * @param string|double $fromLng 起点经度
     * @param string|double $toLat 终点纬度
     * @param string|double $toLng 终点经度
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws Exception
     */
    public function dirBicycling($fromLat, $fromLng, $toLat, $toLng, $extraParams = [])
    {
        return $this->direction('riding', $fromLat, $fromLng, $toLat, $toLng, $extraParams);
    }

    /**
     * 静态图
     * https://lbsyun.baidu.com/index.php?title=static
     *
     * @param string|double $lng 经度
     * @param string|double $lat 纬度
     * @param int $width 宽度(单位：像素)
     * @param int $height 高度(单位：像素)
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws Exception
     */
    public function staticMap($lng, $lat, $width = 400, $height = 400, $extraParams = [])
    {
        $extraParams['width']  = $width;
        $extraParams['height'] = $height;
        $extraParams['center'] = $lng . ',' . $lat;
        return $this->request('/staticimage/v2/', $extraParams);
    }

    /**
     * ip定位
     * https://lbsyun.baidu.com/index.php?title=webapi/ip-api
     *
     * @param string $ip
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws Exception
     */
    public function ip($ip, $extraParams = [])
    {
        $extraParams['ip'] = $ip;
        return $this->request('/location/ip', $extraParams);
    }

    /**
     * 坐标转换
     * https://lbsyun.baidu.com/index.php?title=webapi/guide/changeposition
     *
     * @param string $lngLats 经度前,纬度后,中间用【,】分隔，每组坐标之间使用【;】分隔(116.83,39.12;115.43,30.21)
     * @param int $type 类型：3=火星坐标（gcj02），即高德地图、腾讯地图和MapABC等地图使用的坐标，其它类型参考文档
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws Exception
     */
    public function translate($lngLats, $type, $extraParams = [])
    {
        $extraParams['coords'] = $lngLats;
        $extraParams['from']   = $type;
        return $this->request('/geoconv/v1/', $extraParams);
    }

    /**
     * 天气查询
     * https://lbsyun.baidu.com/index.php?title=webapi/weather
     *
     * @param string $cityCode 行政区划编码 编码列表下载(districtcode)：https://mapopen-website-wiki.cdn.bcebos.com/cityList/weather_district_id.csv
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws Exception
     */
    public function weather($cityCode = '430100', $extraParams = [])
    {
        $extraParams['district_id'] = $cityCode;
        $extraParams['data_type']   = 'all';
        return $this->request('/weather/v1/', $extraParams);
    }

    /**
     * 输入提示
     * https://lbsyun.baidu.com/index.php?title=webapi/place-suggestion-api
     *
     * @param string $query 关键字
     * @param string $region 支持城市及对应百度编码(citycode)https://mapopen-website-wiki.bj.bcebos.com/static_zip/BaiduMap_cityCode_1102.zip
     * @return mixed
     * @throws Exception
     */
    public function suggestion($query, $region)
    {
        $extraParams['query']  = $query;
        $extraParams['region'] = $region;
        return $this->request('/place/v2/suggestion', $extraParams);
    }

    /**
     * 封装的规划方向(轻量)
     * https://lbsyun.baidu.com/index.php?title=webapi/directionlite-v1
     *
     * @param string $direction 规划方式：驾车(driving) 步行(walking) 骑行(riding) 公交(transit)
     * @param string|double $fromLat 起点纬度
     * @param string|double $fromLng 起点经度
     * @param string|double $toLat 终点纬度
     * @param string|double $toLng 终点经度
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws Exception
     */
    protected function direction($direction, $fromLat, $fromLng, $toLat, $toLng, $extraParams = [])
    {
        $extraParams['origin']      = $fromLat . ',' . $fromLng;
        $extraParams['destination'] = $toLat . ',' . $toLng;
        return $this->request('/directionlite/v1/' . $direction, $extraParams);
    }

    /**
     * 封装的请求
     *
     * @param string $path
     * @param array $params
     * @return mixed
     * @throws Exception
     */
    protected function request($path, $params = [])
    {
        $params['output'] = 'json';
        $params['ak']     = $this->ak;

        $url = $this->host . $path . '?' . http_build_query($params);

        $client   = new HttpClient();
        $response = $client->get($url);
        //dump($response->body);
        if ($response->ok()) {
            //如果为图片，直接返回
            if ($response->isImg()) {
                return $response->body;
            }

            $data = $response->json();
            //dump($data);
            if ($data['status'] === 0) {

                if (isset($data['result'])) {
                    return $data['result'];
                } else {
                    return $data;
                }
            }

            throw new Exception($data['message']);
        }
        throw new Exception($response->getErrorMsg());
    }
}
