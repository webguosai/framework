<?php
// +----------------------------------------------------------------------
// | xxx
// +----------------------------------------------------------------------
// | Copyright (c) 2019~2021 www.duxphp.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: json. <501807312@qq.com>
// +----------------------------------------------------------------------


namespace Webguosai\File;


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
}