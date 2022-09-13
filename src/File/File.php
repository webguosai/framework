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
     * @param int $flags
     * @return false|int
     */
    public static function save($path, $data, $flags = null)
    {
        if (is_array($data)) {
            $data = "<?php\nreturn " . var_export($data, true) . ";\n?>";
        }

        return file_put_contents($path, $data, $flags | LOCK_EX);
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

        return array_values(array_filter($res, function ($value) {
            if ($value != '.' && $value != '..') {
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

        $dir  = '';
        $file = $path;
        if (Str::contains($path, '/')) {
            $fg = strrpos($path, '/');

            $dir  = substr($path, 0, $fg);
            $file = substr($path, $fg + 1);
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
     * 删除目录下的所有文件 (只删除文件，会保留顶级目录)
     *
     * @param string $dir 目录
     * @param bool $isDelDir 是否删除目录
     * @return bool
     */
    public static function rmDir($dir, $isDelDir = true)
    {
        //不是目录
        if (!is_dir($dir)) {
            return true;
        }

        //目录不可写
        if (!is_writable($dir)) {
            return false;
        }

        $dirHandle = opendir($dir);
        while ($file = readdir($dirHandle)) {
            if ($file != '.' && $file != '..') {
                $childrenPath = $dir . '/' . $file;
                if (!is_dir($childrenPath)) {
                    @unlink($childrenPath);
                } else {
                    self::rmDir($childrenPath);
                    if (true === $isDelDir) {
                        @rmdir($childrenPath);
                    }
                }
            }
        }
        //关闭目录句柄
        closedir($dirHandle);
        return true;
    }

    /**
     * 文件大小转移为单位
     *
     * @param int $size
     * @return string
     */
    public static function fileSizeToBytes($size)
    {
        $units = array(' B', ' KB', ' MB', ' GB', ' TB');
        for ($i = 0; $size >= 1024 && $i < 4; $i++) {
            $size /= 1024;
        }
        return round($size, 2) . $units[$i];
    }
}
