<?php
// +----------------------------------------------------------------------
// | xxx
// +----------------------------------------------------------------------
// | Copyright (c) 2019~2021 www.duxphp.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: json. <501807312@qq.com>
// +----------------------------------------------------------------------


namespace Webguosai\Message;

use Webguosai\HttpClient;
use Webguosai\Support\MessageAbstract;

class MyWxPush extends MessageAbstract
{
    protected $config = [
        'token'       => '',
        'app_id'      => '',
        'secret'      => '',
        'open_id'     => '',
        'template_id' => '',
    ];

    public function send($title, $content = '')
    {
        $client   = new HttpClient();
        $url      = 'http://wxpush.otayy.cn?a=push';
        $data     = [
            'token'       => $this->config['token'],
            'app_id'      => $this->config['app_id'],
            'secret'      => $this->config['secret'],
            'open_id'     => $this->config['open_id'],
            'template_id' => $this->config['template_id'],
            'title'       => $title,
            'content'     => $content,
        ];
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