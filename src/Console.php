<?php

namespace Webguosai;

use function Couchbase\defaultDecoder;

class Console
{
    /**
     * 默认模块
     * @var array
     */
    public static $module = [
        'ide'   => \Webguosai\Console\Ide::class,
        'issue' => \Webguosai\Console\Issue::class,
    ];

    public static function run()
    {
        $model = $_SERVER["argv"][1];
        $param = $_SERVER["argv"][2];
        if (empty($model)) {
            $model = 'help';
        }
        $modelArray = explode(':', $model, 2);
        $name       = $modelArray[0];
        $method     = $modelArray[1] ?: 'default';

        if (!self::$module[$name]) {
            exit('Module does not exist' . "\n");
        }
        //var_dump(class_exists(self::$module[$name]));
        //var_dump(__DIR__);
        if (!class_exists(self::$module[$name])) {
            exit('The module class does not exist' . "\n");
        }
        $class = new self::$module[$name]();
        if (!$class instanceof \Webguosai\console\ConsoleInterface) {
            exit('The console class must interface class inheritance' . "\n");
        }
        if (!method_exists($class, $method)) {
            exit('Module approach does not exist' . "\n");
        }
        exit(call_user_func([$class, $method], $param) . "\n");


    }
}