<?php

namespace Webguosai\Authentication\Driver;

use Webguosai\Authentication\Authentication;
use Webguosai\Authentication\Exception\TokenExpiredException;
use Webguosai\Authentication\Exception\TokenInvalidException;
use Webguosai\Http\Request;
use Webguosai\Util\Jwt as JWTUtil;

class Jwt implements Authentication
{
    protected $queryKey = 'token';
    public $pre = 'Bearer ';

    /**
     * 解析
     * @return mixed
     * @throws TokenExpiredException
     * @throws TokenInvalidException
     */
    public function parse()
    {
        $jwt = $this->fromQuery();

        if (is_null($jwt)) {
            $jwt = $this->fromHeader();
        }

        return $this->parseJwt($jwt);
    }

    /**
     * 鉴权
     * @param mixed $data
     * @param int $exp
     * @return mixed|string
     */
    public function authenticate($data, $exp = 3600)
    {
        return JWTUtil::encode($data, $exp);
    }

    /**
     * 解析jwt内容
     * @param $jwt
     * @return mixed
     * @throws TokenExpiredException
     * @throws TokenInvalidException
     */
    protected function parseJwt($jwt)
    {
        if (is_null($jwt)) {
            throw new TokenInvalidException();
        }

        $data = JWTUtil::decode($jwt);

        if (is_null($data)) {
            throw new TokenExpiredException();
        }

        return $data;
    }

    /**
     * 从query中获取鉴权信息
     * @return array|mixed|null
     */
    protected function fromQuery()
    {
        return Request::get($this->queryKey, null);
    }

    /**
     * 从header头中获取鉴权信息
     * @return string|string[]|null
     */
    protected function fromHeader()
    {
        $jwt = null;

        $value = $_SERVER['HTTP_AUTHORIZATION'];
        if (!empty($value)) {
            $jwt = str_ireplace($this->pre, '', $value);
        }

        return $jwt;
    }
}
