<?php

namespace Webguosai\Robot;
use Exception;

class TuLing
{
    protected $appkey;
    protected $userid;
    public function __construct($appkey, $userid) {
        $this->appkey = $appkey;
        $this->userid = $userid;
    }

    /**
     * 回复文本
     *
     * @param $keyword
     * @return mixed
     * @throws Exception
     */
    public function replyText($keyword)
    {
        $url = 'http://openapi.tuling123.com/openapi/api/v2';
        $data = [
            "reqType"    => 0,
            "perception" => [
                "inputText" => [
                    "text" => $keyword
                ]
            ],
            "userInfo"   => [
                "apiKey" => $this->appkey,
                "userId" => $this->userid
            ]
        ];
        $response = (new \Webguosai\HttpClient(['timeout' => 5]))->post($url, json_encode($data));

        if ($response->ok()) {
            $data = $response->json();

            if ($data['intent']['code'] === 10004) {
                return $data['results'][0]['values']['text'];
            }

            throw new Exception($data['results'][0]['values']['text']);
        }

        throw new Exception($response->getErrorMsg());
    }
}
