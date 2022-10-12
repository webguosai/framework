<?php

namespace Webguosai\Support;

/**
 * 消息发送抽象类
 */
abstract class MessageAbstract
{
    /**
     * @var array
     */
    protected $config = [];

    /**
     * 初始化
     * @param array $config 配置项
     */
    public function __construct(array $config)
    {
        $this->config = array_merge($this->config, $config);
    }

    /**
     * 发送
     * @param string $title 标题
     * @param string $content 内容
     * @param string $url url跳转地址
     * @return bool
     */
    abstract function send($title, $content, $url);
}
