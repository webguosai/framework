<?php

/**
 * 超级鹰
 * 官网：https://www.chaojiying.com/
 * 试用测试：https://www.chaojiying.com/demo.html
 * 文档：http://www.chaojiying.com/api-5.html
 */

namespace Webguosai\CrackCaptcha;


use Webguosai\Helper\Arr;

class Chaojiying
{
    protected $config = [
        'user'   => '',//用户名
        'pass'   => '',//密码
        'softid' => '',//软件id
    ];
    protected $host = 'http://code.chaojiying.net';

    public function __construct($config = [])
    {
        $this->config = $config;
    }

    /**
     * 识别
     *
     * @param string $captcha 验证码(可以是路径或base64编码)
     * @param string $codeType 验证码类型(1902=常见4~6位数字+字母) 类型列表：https://www.chaojiying.com/price.html
     */
    public function get(string $captcha, $codeType = '1902')
    {
        $data = [
            'codetype' => $codeType,
            'len_min'  => '',
        ];

        if (file_exists($captcha)) {
            $data['userfile'] = new \CURLFile(realpath($captcha));
        } else {
            $data['file_base64'] = $captcha;
        }

        return $this->request('/Upload/Processing.php', $data);
    }

    /**
     * 报错返分 (在调用识别接口后三分钟内请求)
     *
     * @param string $picId 图片标识号,即识别接口返回来的pic_id字段值
     * @return mixed
     * @throws \Exception
     */
    public function reportErr(string $picId)
    {
        $data = [
            'id' => $picId
        ];
        return $this->request('/Upload/ReportError.php', $data);
    }

    /**
     * 查询余额等信息
     *
     * @return mixed
     * @throws \Exception
     */
    public function query()
    {
        return $this->request('/Upload/GetScore.php', []);
    }

    /**
     * 请求
     * @param string $path 路径
     * @param array $data
     * @return mixed
     * @throws \Exception
     */
    protected function request(string $path, array $data)
    {
        $client = new \Webguosai\HttpClient([
            'timeout' => 5,
        ]);

        $url  = $this->host . $path;
        $data = Arr::merge($this->config, $data);

        $response = $client->post($url, $data);
        if ($response->ok()) {
            $json = $response->json();
            if ($json['err_no'] === 0) {
                return $json;
            }
            throw new \Exception($json['err_str']);
        }

        throw new \Exception($response->getErrorMsg());
    }
}