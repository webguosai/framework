<?php

namespace Webguosai\Tests\Enum;

use Webguosai\Util\Enum;

final class UserTypeEnum extends Enum
{
    public static $default = self::STAFF;

    const STAFF  = 'staff';
    const CLIENT = 'client';
    const LEAD   = 'lead';

    //
    public static $maps = [
        self::STAFF  => '职员',
        self::CLIENT => '客户',
        self::LEAD   => '线索',
    ];

}
