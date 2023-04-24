<?php

namespace Webguosai\Http;

use Webguosai\Util\Environment;

class Request
{
    /**
     * 获取所有参数
     *
     * @return array
     */
    public static function all()
    {
        $request = $_REQUEST;

        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        $data = $data ? $data : [];

        return array_merge($request, $data);
    }

    /**
     * 获取参数
     *
     * @param null $key
     * @param null $default
     * @return array|mixed|null
     */
    public static function get($key = null, $default = null)
    {
        $data = self::all();

        if ($key) {
            return $data[$key] ?? $default;
        }

        return $data;
    }

    /**
     * 取得$_SERVER全局变量的值
     *
     * @param null $key
     * @param null $default
     * @return null
     */
    public static function server($key = null, $default = null)
    {
        if (!$key) {
            return $_SERVER;
        }
        return isset($_SERVER[$key]) ? $_SERVER[$key] : $default;
    }

    /**
     * 获取请求头信息
     *
     * @param string $name Content-Type
     * @param null $default 默认值
     * @return array|false|null
     */
    public static function getHeaders(string $name = '', $default = null)
    {
        $headers = [];
        if (!empty($name)) {
            $name = "HTTP_" . str_replace('-', '_', strtoupper($name));
            return self::server($name) ?? $default;
        }
        if (!function_exists('getallheaders')) {
            foreach ($_SERVER as $key => $value)
            {
                if (substr($key, 0, 5) == 'HTTP_')
                {
                    $headers[ucwords(strtolower(str_replace('_', '-', substr($key, 5))), '-')] = $value;
                }
            }
        } else {
            $headers = getallheaders();
        }
        return $headers;
    }

    /**
     * 是否为post请求
     *
     * @return bool
     */
    public static function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST' && (empty($_SERVER['HTTP_REFERER']) || preg_replace("~https?:\/\/([^\:\/]+).*~i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("~([^\:]+).*~", "\\1", $_SERVER['HTTP_HOST']));
    }

    /**
     * 是否为ajax请求
     *
     * @return bool
     */
    public static function isAjax(): bool
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    /**
     * 获取协议加域名加端口地址
     * @return string
     */
    public static function getSiteUrl(): string
    {
        if (Environment::isCli()) {
            return '';
        }

        $url = 'http';

        if (self::server('HTTPS') == 'on') {
            $url .= 's';
        }
        $url .= '://' . self::server('SERVER_NAME');

        if (self::server('SERVER_PORT') !== '80' && self::server('SERVER_PORT') !== '443') {
            $url .= ':' . self::server('SERVER_PORT');
        }

        return $url;
    }

    /**
     * 获取完整的url
     *
     * @return string
     */
    public static function getFullUrl(): string
    {
        $url = self::getSiteUrl();
        if (empty($url)) {
            return '';
        }

        $url .= self::server('REQUEST_URI');

        return $url;
    }

    /**
     * 获取来源
     *
     * @return mixed
     */
    public static function getReferer()
    {
        return self::server('HTTP_REFERER', '');
    }

    /**
     * 获取user-agent
     * @return mixed
     */
    public static function getUserAgent()
    {
        return self::server('HTTP_USER_AGENT', '');
    }

}
