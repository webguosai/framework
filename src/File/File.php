<?php

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
     * 重写 scandir 方法
     * @param string $directory 目录
     * @param int $sortingOrder 0=字母升序 1=字母降序
     * @return array
     */
    public static function scandir(string $directory, $sortingOrder = 0)
    {
        $res = scandir($directory, $sortingOrder);

        return array_values(array_filter($res, function($value) {
            if ($value != '.' && $value != '..'){
                return $value;
            }
        }));
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

    /**
     * 获取一段内容的后缀名
     *
     * @param string $string
     * @return string
     */
    public static function getExtension($string)
    {
        if (Str::contains($string, '.')) {
            return substr(strrchr($string, '.'), 1);
        }

        return '';
    }
}