<?php

namespace Webguosai\Tests\Enum;

use Webguosai\Util\Enum;

final class UserType2Enum extends Enum
{
    public static $default = self::STAFF2;

    const STAFF2  = 'staff2'; // 职员
    const CLIENT2 = 'client2'; // 客户
    const LEAD2   = 'lead2'; // 线索
}
