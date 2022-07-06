<?php

/**
 * env 操作类
 * 演示：

// 设置
EnvHandle::setConfig(__DIR__ . '/.env');
// 获取所有
EnvHandle::all();
// 设置一个(有则修改，无则增加)
EnvHandle::set('key', 'value');
// 批量插入
EnvHandle::insert([
    'key1' => 'value1',
    'key2' => 'value2',
    'key3' => 'value3'
]);
// 获取单个
EnvHandle::get('key');
// 移除
EnvHandle::remove('key');
// 是否存在
EnvHandle::exists('key');
 *
 */

namespace Webguosai\Util;

class EnvHandle
{
    protected static $path;
    protected static $data = null;

    /**
     * 配置
     *
     * @param string $path env文件路径
     */
    public static function setConfig($path)
    {
        self::$path = $path;
    }

    /**
     * 获取所有
     *
     * @return array
     */
    public static function all()
    {
        return self::parseArray();
    }

    /**
     * 获取指定key
     *
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public static function get($key, $default = null)
    {
        $key = strtoupper($key);

        if (self::exists($key)) {
            return self::getValue($key, $default);
        }

        return $default;
    }

    /**
     * 设置key
     *
     * @param $key
     * @param $value
     * @return bool
     */
    public static function set($key, $value)
    {
        $key = strtoupper($key);

        if (self::exists($key)) {
            self::replaceWriter($key, $value);
        } else {
            self::afterWriter($key, $value);
        }

        return self::writerData();
    }

    /**
     * 插入多个
     *
     * @param $array
     * @return bool
     */
    public static function insert($array)
    {
        foreach ($array as $key => $value) {
            $key = strtoupper($key);

            if (self::exists($key)) {
                self::replaceWriter($key, $value);
            } else {
                self::afterWriter($key, $value);
            }
        }

        return self::writerData();
    }

    /**
     * 移除key
     *
     * @param $key
     * @return bool
     */
    public static function remove($key)
    {
        self::$data = preg_replace('/\b' . $key . '[ \t]*=[ \t]*[^\s]*/i', '', self::getData());

        return self::writerData();
    }

    /**
     * key是否存在
     *
     * @param string $key
     * @return bool
     */
    public static function exists($key)
    {
        if (preg_match('/\b' . $key . '[ \t]*=[ \t]*[^\s]*/i', self::getData())) {
            return true;
        }
        return false;
    }

    /**
     * 获取key中的内容
     *
     * @param $key
     * @param $default
     * @return mixed
     */
    protected static function getValue($key, $default)
    {
        if (preg_match('/\b' . $key . '[ \t]*=[ \t]*([^\s]*)/i', self::getData(), $mat)) {
            return $mat[1];
        }
        return $default;
    }

    /**
     * 替换写入
     *
     * @param $key
     * @param $value
     */
    protected static function replaceWriter($key, $value)
    {
        self::$data = preg_replace('/\b' . $key . '[ \t]*=[ \t]*[^\s]*/i', $key . '=' . $value, self::getData());
    }

    /**
     * 追加在后面写入
     *
     * @param $key
     * @param $value
     */
    protected static function afterWriter($key, $value)
    {
        self::$data = self::getData() . PHP_EOL . PHP_EOL . $key . '=' . $value;
    }

    /**
     * 写入
     *
     * @return bool
     */
    protected static function writerData()
    {
        return (bool)file_put_contents(self::$path, self::getData());
    }

    /**
     * 解析为数组
     *
     * @return array
     */
    protected static function parseArray()
    {
        $array = explode(PHP_EOL, self::getData());

        $data = [];
        foreach ($array as $key => $value) {
            if (preg_match('/\b([\w]+)[ \t]*=[ \t]*([^\s]*)/i', $value, $mat)) {
                $data[$mat[1]] = $mat[2];
            }
        }
        return $data;
    }

    /**
     * 获取data
     *
     * @return false|string|null
     */
    protected static function getData()
    {
        if (self::$data === null) {
            // 没有文件则创建
            if (!file_exists(self::$path)) {
                file_put_contents(self::$path, '');
            }

            self::$data = file_get_contents(self::$path);
        }
        return self::$data;
    }

}
