<?php

namespace Webguosai\Authentication\Exception;

use Exception;

class TokenInvalidException extends Exception
{
    protected $message = 'Token is invalid';
}
