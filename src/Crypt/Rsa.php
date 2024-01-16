<?php

namespace Webguosai\Crypt;

class Rsa
{
    /**
     * 创建密钥
     * @param int $bits
     * @return array
     */
    public static function createKeys(int $bits = 1024): array
    {
        $rsa  = new \phpseclib\Crypt\RSA();
        $keys = $rsa->createKey($bits);

        return [
            'publicKey'  => $keys['publickey'],
            'privateKey' => $keys['privatekey'],
        ];
    }

    /**
     * 创建密钥后写入目录中并返回密钥
     * @param mixed $dir 目录后面必须带/
     * @param int $bits
     * @param string $privateFile
     * @param string $publicFile
     * @return array
     */
    public static function createKeysFile($dir = null, int $bits = 1024, string $privateFile = 'private.pem', string $publicFile = 'public.pem'): array
    {
        $keys = self::createKeys($bits);

        if (is_null($dir)) {
            $dir = __DIR__ . '/';
        }

        file_put_contents($dir . $privateFile, $keys['privateKey']);
        file_put_contents($dir . $publicFile, $keys['publicKey']);

        return $keys;
    }

    /**
     * 获取来自目录文件中密钥
     * @param mixed $dir 目录后面必须带/
     * @param string $privateFile
     * @param string $publicFile
     * @return array
     */
    public static function getKeysByDir($dir = null, string $privateFile = 'private.pem', string $publicFile = 'public.pem'): array
    {
        if (is_null($dir)) {
            $dir = __DIR__ . '/';
        }

        $privateKey = file_get_contents($dir . $privateFile);
        $publicKey  = file_get_contents($dir . $publicFile);

        return [
            'privateKey' => $privateKey,
            'publicKey'  => $publicKey,
        ];
    }

    /**
     * 加密
     * @param mixed $data 要加密的数据,支持数组和字符串
     * @param string $key 密钥key(解密那里用的是公钥,这里就要用私钥,反之亦然,我的推荐方式是,给前端的永远叫公钥,后端保存的是私钥)
     * @return string
     */
    public static function encrypt($data, string $key): string
    {
        $rsa = new \phpseclib\Crypt\RSA();
        $rsa->loadKey($key);

        $ciphertext = json_encode($data);
        $ciphertext = $rsa->encrypt($ciphertext);

        return base64_encode($ciphertext);
    }

    /**
     * 解密
     * @param string $ciphertext
     * @param string $key 密钥key(加密那里用的是私钥,这里就要用公钥,反之亦然,我的推荐方式是,给前端的永远叫公钥,后端保存的是私钥)
     * @return mixed 解密失败返回null
     */
    public static function decrypt(string $ciphertext, string $key)
    {
        $rsa = new \phpseclib\Crypt\RSA();
        $rsa->loadKey($key);

        $ciphertext = base64_decode($ciphertext);
        $ciphertext = @$rsa->decrypt($ciphertext);

        return json_decode($ciphertext, true);
    }
}
