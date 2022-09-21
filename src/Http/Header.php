<?php

namespace Webguosai\Http;

class Header
{
    const CODES = [
        // Informational 1xx
        100 => 'Continue',
        101 => 'Switching Protocols',

        // Success 2xx
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-Authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',

        // Redirection 3xx
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',  // 1.1
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        // 306 is deprecated but reserved
        307 => 'Temporary Redirect',

        // Client Error 4xx
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Request Entity Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',

        // Server Error 5xx
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        509 => 'Bandwidth Limit Exceeded'
    ];

    /**
     * 设置http状态码
     *
     * @param int $code
     */
    public static function setHttpCode($code = 200)
    {
        static::setHeader("HTTP/1.0 {$code} " . static::CODES[$code]);
    }

    /**
     * 设置json header头
     */
    public static function setJson()
    {
        static::setHeader('Content-type: application/json');
    }

    /**
     * 设置js header头
     */
    public static function setJs()
    {
        static::setHeader('Content-type: text/javascript');
    }

    /**
     * 设置编码
     *
     * @param string $charset
     */
    public static function setCharset($charset = 'utf-8')
    {
        static::setHeader('Content-Type:text/html; charset=' . $charset);
    }

    /**
     * 跳转url
     * @param string $url
     */
    public static function redirect($url)
    {
        static::setHeader("Location: {$url}");
    }

    /**
     * 浏览器缓存
     * @see:http://blog.csdn.net/nuli888/article/details/51860097
     *
     * @param int $cacheTime 缓存时间(单位：秒)
     */
    public static function browserCache($cacheTime = 60)
    {
        $modified_time = @$_SERVER['HTTP_IF_MODIFIED_SINCE'];
        if (strtotime($modified_time) + $cacheTime > time()) {
            static::setHeader("HTTP/1.1 304");
            exit;
        }
        //发送Last-Modified头标，设置文档的最后的更新日期。
        static::setHeader("Last-Modified: " . gmdate("D, d M Y H:i:s", time()) . " GMT");

        //发送Expires头标，设置当前缓存的文档过期时间，GMT格式
        static::setHeader("Expires: " . gmdate("D, d M Y H:i:s", time() + $cacheTime) . " GMT");

        //发送Cache_Control头标，设置xx秒以后文档过时,可以代替Expires，如果同时出现，max-age优先。
        static::setHeader("Cache-Control: max-age=$cacheTime");
    }

    /**
     * 设置 header头
     *
     * @param string $string 设置的Header头内容
     * @param bool $replace
     * @param null $http_response_code
     */
    public static function setHeader($string, $replace = true, $http_response_code = null)
    {
        return header($string, $replace, $http_response_code);
    }
}
