<?php

namespace Webguosai\Translate;

use Webguosai\HttpClient;
use Exception;

class YouDao
{
    private $appId;
    private $secretKey;
    protected $apiUrl = 'https://openapi.youdao.com';
    public function __construct($appId, $secretKey)
    {
        $this->appId = $appId;
        $this->secretKey = $secretKey;
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
            'appKey'   => $this->appId,
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

    protected function getSign($query, $salt, $curtime)
    {
        $signStr = $this->appId.'2' . $this->truncate($query) . $salt . $curtime . $this->secretKey;
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
