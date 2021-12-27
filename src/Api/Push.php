<?php
// +----------------------------------------------------------------------
// | xxx
// +----------------------------------------------------------------------
// | Copyright (c) 2019~2021 www.duxphp.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: json. <501807312@qq.com>
// +----------------------------------------------------------------------


namespace Webguosai\Api;


use Webguosai\HttpClient;

class Push
{
    static $cursor = 1;
    static $error  = 0;

    /**
     * 开始推送
     *
     * @param string $url 请求链接
     * @param callable $callback 成功的调用
     * @param string $method 请求方法
     * @param array|string $data 请求data
     * @param array|string $headers 请求的header头
     * @param array $params 额外的http实例参数
     * @param int $tryCount 重试次数
     * @return bool
     */
    public static function start(string $url, callable $callback, $method = 'get', $data = [], $headers = [], $params = [], $tryCount = 3)
    {
        // 初始化参数
        static::$cursor = 1;
        static::$error  = 0;

        $params = array_merge([
            'timeout' => 3,
        ], $params);

        $client = new HttpClient($params);

        while (true) {

            // 超过次数, 返回false
            if (static::$cursor > $tryCount) {
                return false;
            }

            $response = $client->$method($url, $data, $headers);
            //dump($response->body);

            if ($response->errorCode === 0) {
                $callRet = call_user_func_array($callback, [$response->httpStatus, $response->body]);

                if ($callRet === true) {
                    return true;
                }
            }

            // 运行结束 + 1
            static::$cursor++;
            static::$error++;
        }

    }
    public static function start2(callable $callback, $tryCount = 3)
    {

//        return $callback();
        $callRet = call_user_func_array($callback, []);
        return $callRet;
        if ($callRet === true) {
            return true;
        }
    }
}