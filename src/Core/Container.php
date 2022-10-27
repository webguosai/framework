<?php

namespace Webguosai\Core;

class Container
{
    /**
     * 容器对象实例
     * @var null
     */
    protected static $instance = null;

    /**
     * 容器绑定标识
     * @var array
     */
    protected $bindings = [];

    /**
     * 绑定到容器
     * @param mixed $abstract
     * @param null $concrete
     * @return $this
     */
    public function bind($abstract, $concrete = null)
    {
        // 支持数组批量绑定
        if (is_array($abstract)) {
            foreach ($abstract as $key => $val) {
                $this->bind($key, $val);
            }
        } else {

            // 支持单个参数绑定
            if (is_null($concrete)) {
                $concrete = $abstract;
            }

            $this->bindings[$abstract] = $concrete;
        }

        return $this;
    }

    /**
     * 取出容器中的数据
     * @param mixed $abstract
     * @param array $params
     * @return mixed|object|$abstract
     */
    public function make($abstract, $params = [])
    {
//        if (!isset($this->bindings[$abstract])) {
//            throw new \Exception('没有在容器中找到');
//        }

        $concrete = $this->bindings[$abstract];
        if ($concrete instanceof \Closure) {
            return call_user_func($concrete, ...$params);
        }

        try {
            $reflector = new \ReflectionClass($concrete);
        } catch (\Exception $e) {
            return $concrete;
        }

        return $reflector->newInstance();
    }

    /**
     * 获取实例
     * @return $this
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}
