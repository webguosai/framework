<?php

namespace Webguosai\Api;

/**
 * api推送
 *
$ret = Push::start(function() use ($client, $url) {
$response = $client->get($url);

if ($response->httpStatus === 200) {
return true;
}
}, 3);

 */
class Push
{
    static $error  = 0;

    /**
     * 推送
     *
     * @param callable $callback 回调函数
     * @param int $tryCount 重试次数
     * @return bool
     */
    public static function start(callable $callback, $tryCount = 3)
    {
        // 初始化参数
        static::$error  = 0;

        for ($i = 0; $i < $tryCount; $i++) {
            $callRet = call_user_func_array($callback, []);

            if ($callRet === true) {
                return true;
            }

            // 运行结束 + 1
            static::$error++;
        }

        return false;
    }
}
