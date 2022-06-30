<?php

/**
 * jwt类
 * 演示：
 *
    Jwt::$key = '123456';
    Jwt::$domain = 'domain.com';
    $code = Jwt::encode(1111, 5);
    var_dump($code);
    var_dump(JWT::decode($code));
 *
 */
namespace Webguosai\Util;

class Jwt
{
    const ALG = 'HS256';
    public static $key = 'GkhFiMmJQYFeiUJ8NxXjr22tbgFXFg6IHSaQR2HK8qU3tMHFlYWBTs6gn2kN7QEq';
    public static $domain = '';
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
            'data' => json_encode($data)
        ];
        if ($exp) {
            $token['exp'] = $time + $exp;
        }
        return \Firebase\JWT\JWT::encode($token, self::$key, self::ALG);
    }

    public static function decode(string $jwt)
    {
        try {
            $params = \Firebase\JWT\JWT::decode($jwt, new \Firebase\JWT\Key(self::$key, self::ALG));
            return json_decode($params->data, true);
        } catch (\Exception $e) {
            return null;
        }
    }
}
