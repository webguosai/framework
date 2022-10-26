<?php

namespace Webguosai\Util;

class Session
{
    /**
     * 实例
     * @var null
     */
    public static $instance = null;

    /**
     * session 保存路径
     * @var null
     */
    public static $path = null;

    /**
     * 初始化session环境
     */
    protected function init()
    {
        session_save_path(static::$path);
//        ini_set('session.gc_maxlifetime', 10);
        session_start();

        return $this;
    }

    /**
     * 设置session保存路径
     * @param string $path
     */
    public static function setPath($path)
    {
        static::$path = $path;
    }

    /**
     * 实例化
     * @return $this
     */
    public static function getInstance()
    {
        if (is_null(static::$instance)) {
            static::$instance = (new static())->init();
        }

        return static::$instance;
    }

    /**
     * 获取
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        if (isset($_SESSION[$name])) {
            return $_SESSION[$name];
        }
        return null;
    }

    /**
     * 设置
     * @param string $name
     * @param mixed $value
     */
    public function set($name, $value)
    {
        $_SESSION[$name] = $value;
    }

    /**
     * 删除
     * @param string $name
     */
    public function delete($name)
    {
        unset($_SESSION[$name]);
    }
}
