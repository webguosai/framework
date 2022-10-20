<?php

namespace Webguosai\Http;

class Cors
{
    /**
     * 设置跨域header头
     *  如果需要携带cookie则需要这样写：Cors::setting($_SERVER['HTTP_ORIGIN'], '*', '*', 'true');
     *
     * @param string|mixed $origin
     * @param string|mixed $headers
     * @param string|mixed $methods
     * @param string|mixed $credentials
     */
    public static function setting($origin = '*', $headers = '*', $methods = '*', $credentials = 'false')
    {
        header('Access-Control-Allow-Origin: ' . $origin);
        header('Access-Control-Allow-Headers: ' . $headers);
        header('Access-Control-Allow-Methods: ' . $methods);
        header('Access-Control-Allow-Credentials: ' . $credentials);
    }
}
