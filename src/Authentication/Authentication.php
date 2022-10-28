<?php

namespace Webguosai\Authentication;

interface Authentication
{
    /**
     * 解析
     * @return mixed
     */
    public function parse();

    /**
     * 赋值
     * @param mixed $data 数据
     * @param int $exp 过期时间(秒)
     * @return mixed
     */
    public function authenticate($data, $exp);
}
