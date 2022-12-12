<?php

namespace Webguosai\Util;

use League\CLImate\CLImate;

/**
 * Cli操作类
 */
class Cli
{
    /**
     * 获取cli模式下的中文输入
     * @return false|string|string[]|void|null
     */
    public static function getChinaInput()
    {
        $cp = sapi_windows_cp_get('');
        if ($cp === 65001) {
            sapi_windows_cp_set(936);

            $input = trim(fgets(STDIN));
            sapi_windows_cp_set($cp);

            return mb_convert_encoding($input, 'utf-8', 'gbk');
        }

        return trim(fgets(STDIN));
    }

    public static function info($text, $isLine = true)
    {
        echo "\e[;36m" . $text . "\e[0m\e[0m".($isLine?"\n":'');
    }

    public static function error($text, $isLine = true)
    {
        echo "\e[;31m" . $text . "\e[0m\e[0m".($isLine?"\n":'');
    }

    public static function success($text, $isLine = true)
    {
        echo "\e[;32m" . $text . "\e[0m\e[0m".($isLine?"\n":'');
    }

    public static function table($data)
    {
        self::getClimate()->table($data);
    }

    /**
     * 打印一行
     * @param string $message
     * @param string $status
     */
    public static function printLine($message = '', $status = 'info')
    {
        if (is_array($message)) {
            $message = json_encode($message, JSON_UNESCAPED_UNICODE);
        }

        self::$status('[' . date('Y-m-d H:i:s') . '] ' . $message);
    }

    /**
     * Climate
     * 仓库：@see https://github.com/thephpleague/climate
     * 文档：@see https://climate.thephpleague.com/terminal-objects/animation/
     */
    public static function getClimate()
    {
        return new CLImate;
    }
}
