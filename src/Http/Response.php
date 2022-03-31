<?php

namespace Webguosai\Http;

class Response
{
    public static function success($message = '', $data = [])
    {
        static::response(0, $message, $data);
    }

    public static function successData($var = [], $data = false, $message = '')
    {
        static::response(0, $message, $data, $var);
    }

    //用于layer表格列表
    public static function successList($data = [], $total = 10, $message = '')
    {
        static::response(0, $message, $data, ['count' => $total]);
    }

    public static function error($message = '', $code = 1, $httpCode = 200)
    {
        //http状态根据需要来指定 401(未授权) 406(不接受)
        static::response($code, $message, false, [], $httpCode);
    }

    // 用于cli下输出
    public static function cliResponse($message = '', $status = 'info') {
        /**
         * 颜色值对照
         * https://blog.yzmcms.com/php/219.html
         */
        if ($status == 'info') {
            $fontColor = 34; //37=白色
        } elseif ($status == 'error') {
            $fontColor = 31;
        } elseif ($status == 'success') {
            $fontColor = 32;
        }

        if (is_array($message)) {
            $message = json_encode($message, JSON_UNESCAPED_UNICODE);
        }

        echo "\e[;{$fontColor}m[". date('Y-m-d H:i:s')."] {$message} \e[0m\e[0m\n";
    }

    protected static function response($code, $message = '', $data = [], $var = [], $httpCode = 200)
    {
        $json = [
            'code'    => $code,
            'message' => $message,
        ];

        if ($data !== false) {
            $json['data'] = $data;
        }

        if ($var !== []) {
            $json = $json + $var;
        }

        HttpHeader::setHttpCode($httpCode);
        HttpHeader::setJson();

        echo json_encode($json);
        exit;
    }
}
