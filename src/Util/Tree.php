<?php

namespace Webguosai\Util;

class Tree
{
    /**
     * 转换为children包裹子数组
     * @param $cate
     * @param mixed $pid
     * @param string $children
     * @param string $id
     * @param string $parentId
     * @return array
     */
    public static function toClass($cate, $pid = 0, string $children = 'children', string $id = 'id', string $parentId = 'parent_id'): array
    {
        $arr = array();
        foreach ($cate as $v) {
            if ($v[$parentId] == $pid) {
                $v[$children] = self::toClass($cate, $v[$id], $children, $id, $parentId);
                $arr[]        = $v;
            }
        }
        return $arr;
    }
}
