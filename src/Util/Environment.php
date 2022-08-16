<?php

namespace Webguosai\Util;

class Environment
{
    /**
     * 是否为 cli运行
     * @return bool
     */
    public static function isCli()
    {
        return self::get() === 'cli';
    }

    /**
     * 获取当前环境
     *
     * @return string
     */
    public static function get()
    {
        return strtolower(PHP_SAPI);
    }
}
