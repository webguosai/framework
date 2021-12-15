<?php
/**
 * WxPusher
 * 官网：http://wxpusher.zjiecode.com/demo
 * 文档：https://wxpusher.zjiecode.com/docs/#/?id=%e5%8f%91%e9%80%81%e6%b6%88%e6%81%af
 */
namespace Webguosai\Message;

use Webguosai\HttpClient;
use Webguosai\Support\MessageAbstract;

class WxPusher extends MessageAbstract
{
    protected $config = [
        'appToken' => '',
        'uid'      => '',
    ];
    public function send($title, $content = '')
    {
        $client = new HttpClient();
        $url = 'http://wxpusher.zjiecode.com/api/send/message';
        $data = [
            'appToken' => $this->config['appToken'],
            'content' => $content,
            'summary' => $title,
            'contentType' => 2,//内容类型 1表示文字  2表示html
            'topicIds' => [],
            'uids' => [$this->config['uid']],
            'url' => '',
        ];
        $headers = ['Content-Type' => 'application/json'];
        $response = $client->post($url, json_encode($data), $headers);

        if ($response->ok()) {
            $data = $response->json();

            if ($data['code'] === 1000) {
                return true;
            }

            throw new \Exception($data['msg']);
        }

        throw new \Exception($response->getErrorMsg());
    }

}