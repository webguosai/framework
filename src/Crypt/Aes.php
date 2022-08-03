<?php

namespace Webguosai\Crypt;

class Aes
{
    private static $base64Hex = false;// 是否将内容base64的16进制编码一次
    private static $key = 'key123'; // 密钥
    private static $iv = '1234567890123456'; // 长度固定为16位
    private static $method = 'AES-128-CBC'; // 默认的加密方式

    /**
     * 配置
     *
     * @param string $key 密钥
     * @param string $iv 长度固定为16位
     * @param string $method 密码的方法(默认为：AES-128-CBC),列表：{@see openssl_get_cipher_methods()}.
     * @param bool $base64Hex 是否将内容base64的16进制编码一次
     */
    public static function config($key, $iv, $method = 'AES-128-CBC', $base64Hex = false)
    {
        self::$key       = $key;
        self::$iv        = $iv;
        self::$method    = $method;
        self::$base64Hex = $base64Hex;
    }

    /**
     * 加密
     *
     * @param mixed $word
     * @return string
     */
    public static function encrypt($word)
    {
        if (is_array($word)) {
            $word = json_encode($word, JSON_UNESCAPED_UNICODE);
        }

        $str = openssl_encrypt($word, self::$method, self::$key, 0, self::$iv);

        // 先base64、再ASCII转16进制
        if (self::$base64Hex) {
            return bin2hex(base64_decode($str));
        }

        return $str;
    }

    /**
     * 解密
     *
     * @param string $encrypt
     * @return mixed
     */
    public static function decrypt($encrypt)
    {
        if (self::$base64Hex) {
            $encrypt = base64_encode(hex2bin($encrypt));
        }

        $decrypt = openssl_decrypt($encrypt, self::$method, self::$key, 0, self::$iv);

        $array = json_decode($decrypt, true);
        if (!is_null($array)) {
            $decrypt = $array;
        }

        return $decrypt;
    }
}