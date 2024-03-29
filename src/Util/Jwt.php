<?php

namespace Webguosai\Util;

class Jwt
{
    const ALG = 'HS256';
    private static $key = 'GkhFiMmJQYFeiUJ8NxXjr22tbgFXFg6IHSaQR2HK8qU3tMHFlYWBTs6gn2kN7QEq';
    private static $domain;
    public static function setConfig($key, $domain = '')
    {
        self::$key = $key;
        self::$domain = $domain;
    }

    /**
     * 加密
     * @param $data
     * @param int $exp
     * @param string|null $iss
     * @param string|null $aud
     * @return string
     */
    public static function encode($data, int $exp = 3600, string $iss = null, string $aud = null)
    {
        $time = time();
        $token = [
            // jwt签发者
            "iss" => $iss ?: self::$domain,
            // 接收jwt的一方
            "aud" => $aud ?: self::$domain,
            // jwt的签发时间
            "iat" => $time,
            // 定义在什么时间之前，该jwt都是不可用的
            "nbf" => $time,
            'data' => serialize($data)
        ];
        if ($exp) {
            $token['exp'] = $time + $exp;
        }
        return \Firebase\JWT\JWT::encode($token, self::$key, self::ALG);
    }

    /**
     * 解码
     * @param string $jwt
     * @return mixed|null
     */
    public static function decode(string $jwt)
    {
        try {
            $params = \Firebase\JWT\JWT::decode($jwt, new \Firebase\JWT\Key(self::$key, self::ALG));
//            return json_decode($params->data, true);
            return unserialize($params->data);
        } catch (\Exception $e) {
            return null;
        }
    }
}
