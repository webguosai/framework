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

        $data = array_merge($request, $data);

        return $data;
    }

    /**
     * 获取参数
     *
     * @param null $key
     * @return array|mixed|null
     */
    public static function get($key = null)
    {
        $data = self::all();

        if ($key) {
            return isset($data[$key]) ? $data[$key] : null;
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
    public static function getHeaders($name = '', $default = null)
    {
        $headers = [];
        if (!empty($name)) {
            $name = "HTTP_" . str_replace('-', '_', strtoupper($name));
            if (isset($_SERVER[$name])) {
                return $_SERVER[$name];
            } else {
                return $default;
            }
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
    public static function isPost()
    {
        return $_SERVER['REQUEST_METHOD'] == 'POST' && (empty($_SERVER['HTTP_REFERER']) || preg_replace("~https?:\/\/([^\:\/]+).*~i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("~([^\:]+).*~", "\\1", $_SERVER['HTTP_HOST']));
    }

    /**
     * 是否为ajax请求
     *
     * @return bool
     */
    public static function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    /**
     * 获取完整的url
     *
     * @return string
     */
    public static function getFullUrl()
    {
        if (Environment::isCli()) {
            return '';
        }

        $url = 'http';

        if ($_SERVER['HTTPS'] == 'on') {
            $url .= 's';
        }
        $url .= '://' . $_SERVER['SERVER_NAME'];

        if ($_SERVER['SERVER_PORT'] !== '80') {
            $url .= ':' . $_SERVER['SERVER_PORT'];
        }

        $url .= $_SERVER['REQUEST_URI'];

        return $url;
    }

    /**
     * 获取来源
     *
     * @return mixed|string
     */
    public static function getReferer()
    {
        if (empty($_SERVER['HTTP_REFERER'])) {
            return '';
        }
        return $_SERVER['HTTP_REFERER'];
    }

}
