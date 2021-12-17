<?php
/**
 * 钉钉自定义机器人
 *
 * 文档：https://open.dingtalk.com/document/robots/custom-robot-access
 */

namespace Webguosai\Message;

use Webguosai\HttpClient;
use Webguosai\Support\MessageAbstract;

class DingRobot extends MessageAbstract
{
    protected $config = [
        'webhook' => '', // https://oapi.dingtalk.com/robot/send?access_token=xxx
        'secret'  => '', // SECxxx
        'atAll'   => false, // at 所有人
    ];
    protected $timestamp = '';

    public function send($title, $content = '', $jumpUrl = '')
    {
        if ($jumpUrl) {
            //$content.= " [链接>>]({$jumpUrl})";
            $content = "[{$content}]({$jumpUrl})";
        }

        $sign      = $this->sign();
        $timestamp = $this->timestamp();
        $url       = $this->config['webhook'] . "&timestamp={$timestamp}&sign={$sign}";

        $data = [
            'msgtype' => 'markdown',
            'markdown'    => [
                'title' => $title,
                'text'  => $content
            ],
            'at'      => [
                'isAtAll' => $this->config['atAll'],
            ]
        ];
        $headers  = ['Content-Type' => 'application/json; charset=utf-8'];
        $client = new HttpClient();
        $response = $client->post($url, json_encode($data), $headers);

        if ($response->ok()) {
            $data = $response->json();
            if ($data['errcode'] === 0) {
                //成功
                return true;
            }

            throw new \Exception($data['errmsg']);
        }

        throw new \Exception($response->getErrorMsg());
    }

    /**
     * 签名
     * @return string
     */
    protected function sign()
    {
        return urlencode(base64_encode(hash_hmac('sha256', $this->timestamp() . "\n" . $this->config['secret'], $this->config['secret'], true)));
    }

    /**
     * 时间戳
     * @return float
     */
    protected function timestamp()
    {
        if (!$this->timestamp) {
            list($msec, $sec) = explode(' ', microtime());
            $this->timestamp = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        }

        return $this->timestamp;
    }

}
