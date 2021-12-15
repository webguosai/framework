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
        //'app_id'  => '',
        //'secret'  => '',
        //'open_id'     => '',
        //'template_id' => '',

    ];

    public function send($title, $content = '')
    {
        $client   = new HttpClient();
        $url      = 'http://wxpush.otayy.cn';
        $data     = [
            'config'  => $this->config,
            'title'   => $title,
            'content' => $content,
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