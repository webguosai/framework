<?php
/**
 * server酱 (每天只能发5条)
 *
 * 申请key：https://sct.ftqq.com/sendkey
 */

namespace Webguosai\Message;

use Webguosai\HttpClient;
use Webguosai\Support\MessageAbstract;

class ServerJ extends MessageAbstract
{
    protected $config = [
        'sendKey' => '',
    ];

    public function send($title, $content = '', $jumpUrl = '')
    {
        if ($jumpUrl) {
            //$content.= " [链接>>]({$jumpUrl})";
            $content = "[{$content}]({$jumpUrl})";
        }

        $url      = "https://sctapi.ftqq.com/{$this->config['sendKey']}.send";
        $post     = [
            'title' => $title,
            'desp'  => $content,
        ];
        $client   = new HttpClient();
        $response = $client->post($url, $post);

        if (in_array($response->httpStatus, [200, 400])) {
            $data = $response->json();
            if ($data['code'] === 0) {
                return true;
            }

            throw new \Exception($data['message']);
        }

        throw new \Exception($response->getErrorMsg());
    }
}