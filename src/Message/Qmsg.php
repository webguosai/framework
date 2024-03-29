<?php

namespace Webguosai\Message;

use Webguosai\HttpClient;
use Webguosai\Support\MessageAbstract;

/**
 * QQ消息推送平台 (未测试)
 *
 * 文档地址：https://qmsg.zendee.cn/api.html
 */
class Qmsg extends MessageAbstract
{
    protected $config = [
        'key' => '',
    ];
    public function send($title, $content, $jumpUrl = '')
    {
        $client = new HttpClient();
        $url = 'https://qmsg.zendee.cn/send/'.$this->config['key'];
        $data = [
            'msg' => $title
        ];

        $response = $client->post($url, http_build_query($data));
        //dd($response->body);
        if ($response->ok()) {
            $data = $response->json();
            if ($data['code'] === 0) {
                return true;
            }

            throw new \Exception($data['reason']);
        }

        throw new \Exception($response->getErrorMsg());
    }
}
