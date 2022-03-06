<?php


namespace Webguosai\Util;


class Zip
{
    /**
     * @var 实例
     */
    static $instance;

    /**
     * 压缩
     *
     * @param string $zip 存放压缩文件的路径
     * @param string $dir 要压缩的目录路径
     * @return mixed
     */
    public static function create(string $zip, string $dir)
    {
        $zippy = static::getInstance();

        return $zippy->create($zip, [$dir]);
    }

    /**
     * 解压
     *
     * @param string $zip 压缩文件路径
     * @param string $dir 解压到哪个目录
     */
    public static function extract(string $zip, string $dir = '.')
    {
        $zippy = static::getInstance();

        // 打开存档
        $archive = $zippy->open($zip);

        // 提取到目录
        $archive->extract($dir);
    }

    /**
     * 获取实例
     * @return mixed
     */
    protected static function getInstance()
    {
        if (!static::$instance) {
            static::$instance = \Alchemy\Zippy\Zippy::load();
        }

        return static::$instance;
    }
}