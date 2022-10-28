<?php

namespace Webguosai\Authentication\Exception;

use Exception;

class TokenExpiredException extends Exception
{
    protected $message = 'The token has expired';
}

