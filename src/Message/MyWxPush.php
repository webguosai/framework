<?php

namespace Webguosai\Message;

use Webguosai\HttpClient;
use Webguosai\Support\MessageAbstract;

/**
 * 自定义的微信推送
 *
 * 服务入口：http://wxpush.otayy.cn
 *
 */
class MyWxPush extends MessageAbstract
{
    protected $config = [
        'token'       => '78a87KEYHfeTD3N7',
        'app_id'      => '',
        'secret'      => '',
        'open_id'     => '',
        'template_id' => '',
    ];

    public function send($title, $content = '', $jumpUrl = '')
    {
        $client   = new HttpClient();
        $url      = 'http://wxpush.otayy.cn?a=push';

        $data = array_merge($this->config, [
            'title'   => $title,
            'content' => $content,
            'url'     => $jumpUrl,
        ]);
        //dd($data);
        $response = $client->post($url, json_encode($data));

        if ($response->ok()) {
            $data = $response->json();

            if ($data['errcode'] === 0) {
                return true;
            }

            throw new \Exception($data['errmsg']);
        }

        throw new \Exception($response->getErrorMsg());
    }
}
