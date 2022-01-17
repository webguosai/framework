<?php
// +----------------------------------------------------------------------
// | xxx
// +----------------------------------------------------------------------
// | Copyright (c) 2019~2021 www.duxphp.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: json. <501807312@qq.com>
// +----------------------------------------------------------------------


namespace Webguosai\File;


use Webguosai\Helper\Str;

class File
{
    /**
     * 保存到文件
     *
     * @param string $path
     * @param string|array $data
     * @return false|int
     */
    public static function save($path, $data)
    {
        if (is_array($data)) {
            $data = "<?php\nreturn " . var_export($data, true) . ";\n?>";
        }

        return file_put_contents($path, $data, LOCK_EX);
    }


    /**
     * 创建文件
     *
     * @param string $path
     * @return bool
     */
    public static function mkFile(string $path)
    {
        $path = str_replace('\\', '/', $path);

        $dir = '';
        $file = $path;
        if (Str::contains($path, '/')) {
            $fg = strrpos($path, '/');

            $dir  = substr($path, 0, $fg);
            $file = substr($path, $fg+1);
        }

        try {
            if ($dir) {
                mkdir($dir, 0777, true);
            }

            if ($file) {
                touch($path);
            }

            return true;
        } catch (\Exception $e) {

        }

        return false;
    }
}