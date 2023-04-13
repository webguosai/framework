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
     * @param int $code
     */
    public static function success($message = '', $data = [], $var = [], $code = 0)
    {
        static::response($code, $message, $data, $var);
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
     * 响应
     *
     * @param $code
     * @param string $message
     * @param array $data
     * @param array $var
     * @param int $httpCode
     */
    public static function response($code, $message = '', $data = [], $var = [], $httpCode = 200)
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
