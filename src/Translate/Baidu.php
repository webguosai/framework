<?php

namespace Webguosai\Translate;

use Webguosai\HttpClient;
use Exception;

class Baidu
{
    protected $options = [
        'appId' => '',
        'secretKey' => '',
    ];
    protected $apiUrl = 'https://fanyi-api.baidu.com';
    protected $error = [
        52000 => '成功',
        52001 => '请求超时',
        52002 => '系统错误',
        52003 => '未授权用户',
        54000 => '必填参数为空',
        54001 => '签名错误',
        54003 => '访问频率受限',
        54004 => '账户余额不足',
        54005 => '长query请求频繁',
        58000 => '客户端IP非法',
        58001 => '译文语言方向不支持',
        58002 => '服务当前已关闭',
        90107 => '认证未通过或未生效',
    ];
    public function __construct($options)
    {
        $this->options = array_merge($this->options, $options);
    }

    /**
     * 翻译
     * https://fanyi-api.baidu.com/doc/21
     *
     * @param string $query 翻译的内容
     * @param string $to 要翻译的语言 (zh, en)
     * @param string $from 翻译内容的语言，auto = 自动检测
     * @return string
     * @throws Exception
     */
    public function translate($query, $to, $from = 'auto')
    {
        $salt = $this->getSalt();
        $data = [
            'q'     => $query,
            'from'  => $from,
            'to'    => $to,
            'salt'  => $salt,
            'sign'  => $this->getSign($query, $salt),
        ];

        return $this->request('/api/trans/vip/translate', $data)['trans_result'][0]['dst'];
    }

    /**
     * 识别语种
     * https://fanyi-api.baidu.com/doc/24
     *
     * @param string $query
     * @return string
     * @throws Exception
     */
    public function language($query)
    {
        $salt = $this->getSalt();
        $data = [
            'q'     => $query,
            'salt'  => $salt,
            'sign'  => $this->getSign($query, $salt),
        ];

        return $this->request('/api/trans/vip/language', $data)['data']['src'];
    }

    protected function getSalt()
    {
        return mt_rand(10000,99999);
    }

    /**
     * 请求
     *
     * @param $path
     * @param $data
     * @return mixed
     * @throws Exception
     */
    protected function request($path, $data)
    {
        $data['appid'] = $this->options['appId'];
        $response = (new HttpClient(['timeout' => 5]))->get($this->apiUrl . $path, $data);

//        dd($response->body);
        if ($response->ok()) {
            $json = $response->json();
            if (!$json) {
                throw new Exception($response->body);
            }

            // 通用翻译正常的状态是 52000
            // 语种识别正常的状态是 0
            if (isset($json['error_code']) && $json['error_code'] !== 52000 && $json['error_code'] !== 0) {

                if (isset($this->error[$json['error_code']])) {
                    throw new Exception($this->error[$json['error_code']]);
                }

                throw new Exception("{$json['error_msg']}({$json['error_code']})");
            }

            return $json;
        }

        throw new Exception($response->getErrorMsg());
    }

    protected function getSign($query, $salt)
    {
        return md5($this->options['appId'].$query.$salt.$this->options['secretKey']);
    }

}
