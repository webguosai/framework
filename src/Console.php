<?php

namespace Webguosai;

class Console
{
    public static function run()
    {
        $model = $_SERVER["argv"][1];
        $param = $_SERVER["argv"][2];
        if (empty($model)) {
            $model = 'help';
        }
        $modelArray = explode(':', $model, 2);
        $name       = $modelArray[0];
        $method     = $modelArray[1] ?: 'handle';

        $className = '\Webguosai\Console\\'.ucfirst($name);

        if (!class_exists($className)) {
            exit('The module class does not exist' . "\n");
        }
        $class = new $className();
        if (!method_exists($class, $method)) {
            exit('Module approach does not exist' . "\n");
        }

        $class->$method($param);
        //exit(call_user_func([$class, $method], $param) . "\n");
        exit("\n");
    }
}