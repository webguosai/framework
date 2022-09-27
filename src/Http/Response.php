<?php

namespace Webguosai\Http;

class Response
{
    /**
     * 输出类型
     */
    protected static $outputType = 'json';

    /**
     * 设置输出类型
     *
     * @param $type
     */
    public static function setType($type) {
        self::$outputType = $type;
    }

    /**
     * 成功
     *
     * @param string $message
     * @param array $data
     * @param array $var
     */
    public static function success($message = '', $data = [], $var = [])
    {
        static::response(0, $message, $data, $var);
    }

    /**
     * 失败
     *
     * @param string $message
     * @param int $code
     * @param int $httpCode
     */
    public static function error($message = '', $code = 1, $httpCode = 200)
    {
        //http状态根据需要来指定 401(未授权) 406(不接受)
        static::response($code, $message, [], [], $httpCode);
    }

    /**
     * cli下输出
     *
     * @param string $message
     * @param string $status
     */
    public static function cliResponse($message = '', $status = 'info')
    {
        /**
         * 颜色值对照
         * @see:https://blog.yzmcms.com/php/219.html
         */
        // 默认白色
        $fontColor = 34;
        if ($status == 'error') {
            $fontColor = 31;
        } elseif ($status == 'success') {
            $fontColor = 32;
        }

        if (is_array($message)) {
            $message = json_encode($message, JSON_UNESCAPED_UNICODE);
        }

        echo "\e[;{$fontColor}m[". date('Y-m-d H:i:s')."] {$message} \e[0m\e[0m\n";
    }

    /**
     * 响应
     *
     * @param $code
     * @param string $message
     * @param array $data
     * @param array $var
     * @param int $httpCode
     */
    protected static function response($code, $message = '', $data = [], $var = [], $httpCode = 200)
    {
        $json = [
            'code'    => $code,
            'message' => $message,
        ];

        $json['data'] = $data;

        if (!empty($var)) {
            $json = $json + $var;
        }

        Header::setHttpCode($httpCode);
        Header::setJson();

        if (self::$outputType === 'jsonp') {
            $callback = !empty($_REQUEST['callback']) ? htmlspecialchars($_REQUEST['callback']) : 'jsonp_' . time() . mt_rand(100, 999);
            echo $callback . '(' . json_encode($json, JSON_UNESCAPED_UNICODE) . ')';
        } else {
            echo json_encode($json, JSON_UNESCAPED_UNICODE);
        }
        exit;
    }
}
