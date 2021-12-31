<?php

/**
 * 高德地图
 *
 * 文档：https://lbs.amap.com/api/webservice/gettingstarted
 *
 */

namespace Webguosai\Map;


use Webguosai\HttpClient;

class GaodeMap
{
    protected $key;
    protected $host = 'https://restapi.amap.com';
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * 地址转坐标
     * https://lbs.amap.com/api/webservice/guide/api/georegeo#geo
     *
     * @param string $address 地址：湖南省长沙市
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws \Exception
     */
    public function geoAddress(string $address, $extraParams = [])
    {
        $extraParams['address'] = $address;
        return $this->request('/v3/geocode/geo', $extraParams);
    }

    /**
     * 坐标转地址
     * https://lbs.amap.com/api/webservice/guide/api/georegeo#regeo
     *
     * @param string|double $lat 纬度：39.984154
     * @param string|double $lng 经度：116.307490
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws \Exception
     */
    public function geoLocation($lat, $lng, $extraParams = [])
    {
        $extraParams['location'] = "{$lng},{$lat}";
        return $this->request('/v3/geocode/regeo', $extraParams);
    }

    /**
     * 静态图
     * https://lbs.amap.com/api/webservice/guide/api/staticmaps#staticmap
     *
     * @param string|double $lng 经度
     * @param string|double $lat 纬度
     * @param int $width 宽度(单位：像素)
     * @param int $height 高度(单位：像素)
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws \Exception
     */
    public function staticMap($lng, $lat, $width = 400, $height = 400, $extraParams = [])
    {
        $extraParams['size']     = $width . '*' . $height;
        $extraParams['location'] = $lng . ',' . $lat;
        $extraParams['scale']    = 2;//1=普通图,2=高清图
        return $this->request('/v3/staticmap', $extraParams);
    }


    /**
     * ip定位
     * https://lbs.amap.com/api/webservice/guide/api/ipconfig#instructions
     *
     * @param string $ip
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws \Exception
     */
    public function ip($ip, $extraParams = [])
    {
        $type = 4;
        if (filter_var($ip, \FILTER_VALIDATE_IP,\FILTER_FLAG_IPV6)) {
            $type = 6;
        }

        $extraParams['ip']   = $ip;
        $extraParams['type'] = $type;
        return $this->request('/v5/ip', $extraParams);
    }

    /**
     * 天气查询
     * https://lbs.amap.com/api/webservice/guide/api/weatherinfo
     *
     * @param string $cityCode 行政区划编码 编码列表下载：https://a.amap.com/lbs/static/amap_3dmap_lite/AMap_adcode_citycode.zip
     * @param array $extraParams 额外参数请参照文档
     * @return mixed
     * @throws \Exception
     */
    public function weather($cityCode = '430101', $extraParams = [])
    {
        $extraParams['city']       = $cityCode;
        $extraParams['extensions'] = 'all';
        return $this->request('/v3/weather/weatherInfo', $extraParams);
    }

    /**
     * 输入提示
     * https://lbs.amap.com/api/webservice/guide/api/inputtips
     *
     * @param string $keyword 关键字
     * @param sting $region 缺省时侧进行全国范围搜索
     * @return mixed
     * @throws \Exception
     */
    public function suggestion($keyword, $region)
    {
        $extraParams['keywords'] = $keyword;
        $extraParams['city']     = $region;
        return $this->request('/v3/assistant/inputtips', $extraParams);
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
        $params['output'] = 'JSON';
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

            if ($data['status'] == '1') {
                return $data;
            }

            throw new \Exception($data['info']);
        }

        throw new \Exception($response->getErrorMsg());
    }
}