<?php

/**
 * 非谷歌官网接口，解的是页面：https://translate.google.cn/?sl=zh-CN&tl=en&text=%E4%B8%AD%E5%9B%BD&op=translate
 *
 */
namespace Webguosai\Translate;

use Webguosai\HttpClient;
use Exception;

class Google
{
    protected $apiUrl = 'https://translate.google.cn/_/TranslateWebserverUi/data/batchexecute';
    protected $cookie = 'NID=511=WOyrUe8e9jpFev16Qo0vv0742I-JSthmwn5_aAuIQOzvJwbVFDgKDQJfUYw0VMWzduUUJIzSHHP-n6NBDEEk0Y44lCNzVu75Y1EnniInn8bU93FMsO_tFNsBOPx9EU6K8IhBDm9I-f2xQt4SGUkqLt_wEhTF484GFdtB0iK9GZM';
    public function __construct($cookie = null)
    {
        if ($cookie) {
            $this->cookie = $cookie;
        }
    }

    /**
     * 翻译
     * https://translate.google.cn/?sl=zh-CN&tl=en&text=%E4%B8%AD%E5%9B%BD&op=translate
     *
     * @param string $query 翻译的内容
     * @param string $to 要翻译的语言 (zh-CH,en)
     * @param string $from 翻译内容的语言，auto = 自动检测
     * @return mixed
     * @throws Exception
     */
    public function translate($query, $to, $from = 'auto')
    {
        $data = http_build_query([
//            'f.req' => '[[["MkEWBc","[[\"'.$query.'\",\"zh-CN\",\"en\",true],[null]]",null,"generic"]]]'
            'f.req' => '[[["MkEWBc","[[\"'.$query.'\",\"'.$from.'\",\"'.$to.'\",true],[null]]",null,"generic"]]]'
        ]);
        $ret = $this->request($data);

        if (preg_match('/null,null,null,\[\[\\\"(.+?)\\\"/i', $ret, $mat)) {
            return $mat[1];
        }

        throw new Exception('no translation found.');
    }

    /**
     * 请求
     *
     * @param $data
     * @return mixed
     * @throws Exception
     */
    protected function request($data)
    {
        $headers = [
            'cookie' => $this->cookie,
        ];
        $response = (new HttpClient())->post($this->apiUrl, $data, $headers);

        if ($response->ok()) {
            return $response->body;
        }
        throw new Exception($response->getErrorMsg());
    }
}
