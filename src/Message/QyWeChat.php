<?php

namespace Webguosai\Message;

use Webguosai\HttpClient;
use Webguosai\Support\MessageAbstract;
use Exception;

/**
 * 企业微信群机器人
 *
 * 文档：https://developer.work.weixin.qq.com/document/path/99110
 */
class QyWeChat extends MessageAbstract
{
    protected $config = [
        'key'   => '',
    ];

    public function send($title, $content = '', $jumpUrl = '')
    {
        if ($jumpUrl) {
            $content = "[{$content}]({$jumpUrl})";
        }

        $url = 'https://qyapi.weixin.qq.com/cgi-bin/webhook/send?key=' . $this->config['key'];

        $data     = [
            'msgtype'  => 'markdown',
            'markdown' => [
                'content' => $content,
            ],
        ];
        $headers  = ['Content-Type' => 'application/json; charset=utf-8'];
        $client   = new HttpClient();
        $response = $client->post($url, json_encode($data), $headers);

        if ($response->ok()) {
            $data = $response->json();
            if ($data['errcode'] === 0) {
                return true;
            }

            throw new Exception($data['errmsg']);
        }

        throw new Exception($response->getErrorMsg());
    }

}
