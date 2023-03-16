<?php

namespace Webguosai\Translate;

use Webguosai\HttpClient;
use Exception;

class YouDao
{
    protected $options = [
        'appId' => '',
        'secretKey' => '',
    ];
    protected $apiUrl = 'https://openapi.youdao.com';
    protected $error = [
        101 => '缺少必填的参数,首先确保必填参数齐全，然后确认参数书写是否正确。',
        102 => '不支持的语言类型',
        103 => '翻译文本过长',
        104 => '不支持的API类型',
        105 => '不支持的签名类型',
        106 => '不支持的响应类型',
        107 => '不支持的传输加密类型',
        108 => '应用ID无效，注册账号，登录后台创建应用并完成绑定，可获得应用ID和应用密钥等信息',
        109 => 'batchLog格式不正确',
        110 => '无相关服务的有效应用,应用没有绑定服务应用，可以新建服务应用。注：某些服务的翻译结果发音需要tts服务，需要在控制台创建语音合成服务绑定应用后方能使用。',
        111 => '开发者账号无效',
        112 => '请求服务无效',
        113 => 'q不能为空',
        114 => '不支持的图片传输方式',
        116 => 'strict字段取值无效，请参考文档填写正确参数值',
        201 => '解密失败，可能为DES,BASE64,URLDecode的错误',
        202 => '签名检验失败,如果确认应用ID和应用密钥的正确性，仍返回202，一般是编码问题。请确保翻译文本 q 为UTF-8编码.',
        203 => '访问IP地址不在可访问IP列表',
        205 => '请求的接口与应用的平台类型不一致，确保接入方式（Android SDK、IOS SDK、API）与创建的应用平台类型一致。如有疑问请参考入门指南',
        206 => '因为时间戳无效导致签名校验失败',
        207 => '重放请求',
        301 => '辞典查询失败',
        302 => '翻译查询失败',
        303 => '服务端的其它异常',
        304 => '会话闲置太久超时',
        308 => 'rejectFallback参数错误',
        309 => 'domain参数错误',
        310 => '未开通领域翻译服务',
        401 => '账户已经欠费，请进行账户充值',
        402 => 'offlinesdk不可用',
        411 => '访问频率受限,请稍后访问',
        412 => '长请求过于频繁，请稍后访问',
        1001 => '无效的OCR类型',
        1002 => '不支持的OCR image类型',
        1003 => '不支持的OCR Language类型',
        1004 => '识别图片过大',
        1201 => '图片base64解密失败',
        1301 => 'OCR段落识别失败',
        1411 => '访问频率受限',
        1412 => '超过最大识别字节数',
        2003 => '不支持的语言识别Language类型',
        2004 => '合成字符过长',
        2005 => '不支持的音频文件类型',
        2006 => '不支持的发音类型',
        2201 => '解密失败',
        2301 => '服务的异常',
        2411 => '访问频率受限,请稍后访问',
        2412 => '超过最大请求字符数',
        3001 => '不支持的语音格式',
        3002 => '不支持的语音采样率',
        3003 => '不支持的语音声道',
        3004 => '不支持的语音上传类型',
        3005 => '不支持的语言类型',
        3006 => '不支持的识别类型',
        3007 => '识别音频文件过大',
        3008 => '识别音频时长过长',
        3009 => '不支持的音频文件类型',
        3010 => '不支持的发音类型',
        3201 => '解密失败',
        3301 => '语音识别失败',
        3302 => '语音翻译失败',
        3303 => '服务的异常',
        3411 => '访问频率受限,请稍后访问',
        3412 => '超过最大请求字符数',
        4001 => '不支持的语音识别格式',
        4002 => '不支持的语音识别采样率',
        4003 => '不支持的语音识别声道',
        4004 => '不支持的语音上传类型',
        4005 => '不支持的语言类型',
        4006 => '识别音频文件过大',
        4007 => '识别音频时长过长',
        4201 => '解密失败',
        4301 => '语音识别失败',
        4303 => '服务的异常',
        4411 => '访问频率受限,请稍后访问',
        4412 => '超过最大请求时长',
        5001 => '无效的OCR类型',
        5002 => '不支持的OCR image类型',
        5003 => '不支持的语言类型',
        5004 => '识别图片过大',
        5005 => '不支持的图片类型',
        5006 => '文件为空',
        5201 => '解密错误，图片base64解密失败',
        5301 => 'OCR段落识别失败',
        5411 => '访问频率受限',
        5412 => '超过最大识别流量',
        9001 => '不支持的语音格式',
        9002 => '不支持的语音采样率',
        9003 => '不支持的语音声道',
        9004 => '不支持的语音上传类型',
        9005 => '不支持的语音识别 Language类型',
        9301 => 'ASR识别失败',
        9303 => '服务器内部错误',
        9411 => '访问频率受限（超过最大调用次数）',
        9412 => '超过最大处理语音长度',
        10001 => '无效的OCR类型',
        10002 => '不支持的OCR image类型',
        10004 => '识别图片过大',
        10201 => '图片base64解密失败',
        10301 => 'OCR段落识别失败',
        10411 => '访问频率受限',
        10412 => '超过最大识别流量',
        11001 => '不支持的语音识别格式',
        11002 => '不支持的语音识别采样率',
        11003 => '不支持的语音识别声道',
        11004 => '不支持的语音上传类型',
        11005 => '不支持的语言类型',
        11006 => '识别音频文件过大',
        11007 => '识别音频时长过长，最大支持30s',
        11201 => '解密失败',
        11301 => '语音识别失败',
        11303 => '服务的异常',
        11411 => '访问频率受限,请稍后访问',
        11412 => '超过最大请求时长',
        12001 => '图片尺寸过大',
        12002 => '图片base64解密失败',
        12003 => '引擎服务器返回错误',
        12004 => '图片为空',
        12005 => '不支持的识别图片类型',
        12006 => '图片无匹配结果',
        13001 => '不支持的角度类型',
        13002 => '不支持的文件类型',
        13003 => '表格识别图片过大',
        13004 => '文件为空',
        13301 => '表格识别失败',
        15001 => '需要图片',
        15002 => '图片过大（1M）',
        15003 => '服务调用失败',
        17001 => '需要图片',
        17002 => '图片过大（1M）',
        17003 => '识别类型未找到',
        17004 => '不支持的识别类型',
        17005 => '服务调用失败',
    ];
    public function __construct($options)
    {
        $this->options = array_merge($this->options,$options);
    }

    /**
     * 翻译
     * https://ai.youdao.com/DOCSIRMA/html/%E8%87%AA%E7%84%B6%E8%AF%AD%E8%A8%80%E7%BF%BB%E8%AF%91/API%E6%96%87%E6%A1%A3/%E6%96%87%E6%9C%AC%E7%BF%BB%E8%AF%91%E6%9C%8D%E5%8A%A1/%E6%96%87%E6%9C%AC%E7%BF%BB%E8%AF%91%E6%9C%8D%E5%8A%A1-API%E6%96%87%E6%A1%A3.html
     *
     * @param string $query 翻译的内容
     * @param string $to 要翻译的语言 (zh-CHS,en)
     * @param string $from 翻译内容的语言，auto = 自动检测
     * @return mixed
     * @throws Exception
     */
    public function translate($query, $to, $from = 'auto')
    {
        $salt = uniqid();
        $curtime = time();
        $data = [
            'q'        => $query,
            'appKey'   => $this->options['appId'],
            'salt'     => $salt,
            'from'     => $from,
            'to'       => $to,
            'signType' => 'v3',
            'curtime'  => $curtime,
            'sign'     => $this->getSign($query, $salt, $curtime),
        ];

        return $this->request('/api', $data)['translation'][0];
    }

    // 官方没有
    public function language($query)
    {
        //
        return 'zh';
    }

//    public function translateHtml($query, $from, $to)
//    {
//        $salt = uniqid();
//        $curtime = time();
//        $data = [
//            'q'        => $query,
//            'from'     => $from,
//            'to'       => $to,
//            'appKey'   => $this->options['appId'],
//            'salt'     => $salt,
//            'sign'     => $this->getSign($query, $salt, $curtime),
//            'signType' => 'v3',
//            'curtime'  => $curtime,
//        ];
//
//        return $this->request('/translate_html', $data);
//    }

    protected function getSign($query, $salt, $curtime)
    {
        $signStr = $this->options['appId'] . $this->truncate($query) . $salt . $curtime . $this->options['secretKey'];
        return hash("sha256", $signStr);
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
        $response = (new HttpClient(['timeout' => 5]))->post($this->apiUrl . $path, $data);
        if ($response->ok()) {
            $json = $response->json();
//            dump($json);
            if ($json['errorCode'] === "0") {
                return $json;
            }

            if (isset($this->error[$json['errorCode']])) {
                throw new Exception($this->error[$json['errorCode']]);
            }

            throw new Exception("errorCode:{$json['errorCode']}");
        }

        throw new Exception($response->getErrorMsg());
    }

    protected function truncate($q)
    {
        $len = $this->abslength($q);
        return $len <= 20 ? $q : (mb_substr($q, 0, 10) . $len . mb_substr($q, $len - 10, $len));
    }

    protected function abslength($str)
    {
        if(empty($str)){
            return 0;
        }
        if(function_exists('mb_strlen')){
            return mb_strlen($str,'utf-8');
        }
        else {
            preg_match_all("/./u", $str, $ar);
            return count($ar[0]);
        }
    }

//    protected function create_guid()
//    {
//        $microTime = microtime();
//        list($a_dec, $a_sec) = explode(" ", $microTime);
//        $dec_hex = dechex($a_dec* 1000000);
//        $sec_hex = dechex($a_sec);
//        $this->ensure_length($dec_hex, 5);
//        $this->ensure_length($sec_hex, 6);
//        $guid = "";
//        $guid .= $dec_hex;
//        $guid .= $this->create_guid_section(3);
//        $guid .= '-';
//        $guid .= $this->create_guid_section(4);
//        $guid .= '-';
//        $guid .= $this->create_guid_section(4);
//        $guid .= '-';
//        $guid .= $this->create_guid_section(4);
//        $guid .= '-';
//        $guid .= $sec_hex;
//        $guid .= $this->create_guid_section(6);
//        return $guid;
//    }
//    protected function ensure_length(&$string, $length){
//        $strlen = strlen($string);
//        if($strlen < $length)
//        {
//            $string = str_pad($string, $length, "0");
//        }
//        else if($strlen > $length)
//        {
//            $string = substr($string, 0, $length);
//        }
//    }
//    protected function create_guid_section($characters){
//        $return = "";
//        for($i = 0; $i < $characters; $i++)
//        {
//            $return .= dechex(mt_rand(0,15));
//        }
//        return $return;
//    }
}
