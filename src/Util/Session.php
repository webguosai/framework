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
     * 过期时间
     * @var int
     */
    public static $lifeTime = 1440;

    /**
     * 过期时间key名
     * @var string
     */
//    protected $expireKeyName = '__Session_Expire_Time__';

    /**
     * 初始化session环境
     */
    protected function init()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            ini_set('session.gc_maxlifetime', static::$lifeTime);
            session_save_path(static::$path);
            session_start();

//            $this->setExpireTime();
        }

        return $this;
    }

    /**
     * 设置session保存路径
     * @param string $path session保存路径
     * @param int $lifeTime 过期时间(秒)
     */
    public static function setConfig($path, $lifeTime = 1440)
    {
        static::$path     = $path;
        static::$lifeTime = $lifeTime;
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
//        if ($this->isExpire()) {
//            $this->delete(null);
//            return null;
//        }

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
    public function delete($name = null)
    {
        if (is_null($name)) {
            $_SESSION = [];
            unset($_SESSION);
        } else {
            unset($_SESSION[$name]);
        }
    }


    /**
     * 设置过期时间
     */
//    protected function setExpireTime()
//    {
//        if (empty($_SESSION[$this->expireKeyName])) {
//            $this->set($this->expireKeyName, time() + static::$lifeTime);
//        }
//    }

    /**
     * 是否过期
     * @return bool
     */
//    protected function isExpire()
//    {
//        $expireTime = $_SESSION[$this->expireKeyName];
//        return $expireTime < time();
//    }

}
