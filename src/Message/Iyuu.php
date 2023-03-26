<?php

namespace Webguosai\Message;

use Webguosai\Support\MessageAbstract;

/**
 * 爱语飞飞 (目前不限条，不限速率)
 *
 * 文档：https://iyuu.cn/help.html
 */
class Iyuu extends MessageAbstract
{
    protected $config = [
        'token' => '',
    ];

    public function send($title, $content, $jumpUrl = '')
    {
        $url     = 'http://iyuu.cn/'. $this->config['token'] .'.send';
        $data    = [
            'text' => $title,
            'desp' => $content
        ];
        $response = (new \Webguosai\HttpClient())->post($url, $data);

        if ($response->ok()) {
            $json = $response->json();

            if($json['errcode'] === 0) {
                return true;
            }

            throw new \Exception($json['errmsg']);
        }

        throw new \Exception($response->getErrorMsg());
    }
}
