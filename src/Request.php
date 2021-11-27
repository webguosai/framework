<?php

namespace Webguosai;

class Request
{
    public static function all()
    {
        $request = $_REQUEST;

        $data = file_get_contents('php://input');
        $data = json_decode($data, true);
        $data = $data ? $data : [];

        $data = array_merge($request, $data);

        return $data;
    }

    public static function isPost()
    {
        return ($_SERVER['REQUEST_METHOD'] == 'POST' && (empty($_SERVER['HTTP_REFERER']) || preg_replace("~https?:\/\/([^\:\/]+).*~i", "\\1", $_SERVER['HTTP_REFERER']) == preg_replace("~([^\:]+).*~", "\\1", $_SERVER['HTTP_HOST']))) ? true : false;
    }

    public static function isAjax()
    {
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取参数
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
}