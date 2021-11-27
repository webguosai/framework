<?php

namespace Webguosai;

use Webguosai\HttpClient;

/**
 * 钉钉
 *
 */
class DingTalk
{
    /**
     * 推送机器人消息
     *   接入文档：https://developers.dingtalk.com/document/robots/custom-robot-access
     *
     * @param $msg
     * @param $webhook
     * @param $secret
     * @param bool $atAll
     * @return bool
     */
    public static function pushRobotMsg($msg, $webhook, $secret, $atAll = false)
    {
        $sign_get = '';

        if (!empty($secret)) {
            list($msec, $sec) = explode(' ', microtime());
            $timestamp = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
            //$timestamp = get_timestamp();
            $sign = urlencode(base64_encode(hash_hmac('sha256', $timestamp . "\n" . $secret, $secret, true)));

            $sign_get = "&timestamp={$timestamp}&sign={$sign}";
        }

        $data = array(
            'msgtype' => 'text',
            'text'    => array(
                'content' => $msg
            ),
            'at'      => array(
                'isAtAll' => $atAll,
            )
        );
        $data = json_encode($data);

        $client   = new HttpClient();
        $headers  = [
            'Content-Type' => 'application/json;charset=utf-8'
        ];
        $url      = $webhook . $sign_get;
        $response = $client->post($url, $data, $headers);

        if ($response->ok()) {
            $data = $response->json();
            if ($data['errcode'] === 0) {
                //成功
                return true;
            }
        }

        return false;

//        $params = array(
//            'link'     => $webhook.$sign_get,
//            'get_data' => true,
//            'post'     => $data_string,
//            'header' => array ('Content-Type: application/json;charset=utf-8')
//        );
//        $data = get_http_data($params);

//        if($data['error_code']) {
//            return ['code' => 1, 'message' => '接口未返回内容'];
//        }
//
//        $return_data = json_decode($data['html'], true);
//
//        if($return_data['errcode'] == 0) {
//            //成功
//            return ['code' => 0, 'message' => $return_data['errmsg']];
//        }
//
//        return ['code' => $return_data['errcode'], 'message' => $return_data['errmsg']];
    }

}
