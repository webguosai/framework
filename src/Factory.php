<?php

namespace Webguosai;


use Webguosai\Helper\Str;

class Factory
{
    public static function make($name, array $config)
    {
        $namespace = Str::studly($name);
        $application = "\\Webguosai\\{$namespace}";

        return new $application($config);
    }

    public static function __callStatic($name, $arguments)
    {
        return self::make($name, ...$arguments);
    }
}