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
