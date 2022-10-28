<?php

namespace Webguosai\Authentication\Driver;

use Webguosai\Authentication\Authentication;
use Webguosai\Util\Session as SessionUtil;

class Session implements Authentication
{
    protected $sessionKeyName = 'user';

    public function parse()
    {
        return SessionUtil::getInstance()->get($this->sessionKeyName);
    }

    public function authenticate($data, $exp)
    {
        SessionUtil::getInstance()->set($this->sessionKeyName, $data);

        return true;
    }
}
