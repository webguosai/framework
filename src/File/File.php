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
     * 删除目录下的所有文件
     * (只删除文件，会保留目录)
     *
     * @param $dir
     * @return bool
     */
    public static function rmDir($dir)
    {
        //不是目录
        if (!is_dir($dir)) {
            return true;
        }

        //目录不可写
        if (!is_writable($dir)) {
            return false;
        }

        $dir_handle = opendir($dir);
        while ($file = readdir($dir_handle)) {
            if ($file != '.' && $file != '..') {
                $children_path = $dir . '/' . $file;
                if (!is_dir($children_path)) {
                    @unlink($children_path);
                } else {
                    self::rmDir($children_path);
                    @rmdir($children_path);
                }
            }
        }
        //关闭目录句柄
        closedir($dir_handle);
        return true;
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

    /**
     * 获取一段url中的文件名(不含后缀)
     *
     * @param string $url
     * @return mixed|string
     */
    public static function getFileName($url)
    {
        return pathinfo($url, PATHINFO_FILENAME);
    }

    /**
     * 获取一段url中的文件名加后缀
     *
     * @param string $url
     * @return mixed|string
     */
    public static function getBaseName($url)
    {
        return pathinfo($url, PATHINFO_BASENAME);
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
        return round($size, 2).$units[$i];
    }
}
