<?php

/**
 * 文本识别
 */
namespace Webguosai\Util;

class TextIdentify
{
    protected $text;
    public function __construct($text)
    {
        $this->text = $text;
    }

    public function getName() {
        $name = '';
        $rex = '#我(?:叫|姓)([\x{4e00}-\x{9fa5}]{2,4})#iu';
        if (preg_match($rex, $this->text, $mat)) {
            $name = $mat[1];
        }

        return $name;
    }

    public function getSex()
    {
        $sex = '';
        if (preg_match('#(男|儿子)#i', $this->text)) {
            $sex = '男';
        }

        if (preg_match('#女#i', $this->text)) {
            $sex = '女';
        }

        return $sex;
    }

    public function getMobile()
    {
        $mobile = '';
        $rex = '#[^a-zA-Z]*(1[3|4|5|6|7|8|9]{1}\d{9})#i';
        if (preg_match($rex, $this->text, $mat)) {
            $mobile = $mat[1];
        }

        return $mobile;
    }

    public function getWeChat()
    {
        $weChat = '';
        $rex  = '#([a-zA-Z]{1}[a-zA-Z\d_-]{5,19})#i';
        $rex2 = '#([1-9]{1}[0-9]{4,11})#i';

        if (preg_match($rex, $this->text, $mat)) {
            //匹配微信号官方格式
            $weChat = $mat[1];
        } elseif (preg_match($rex2, $this->text, $mat)) {
            //匹配是否为QQ号，因为通过QQ号也能查找出微信号
            $weChat = $mat[1];
        }

        // 如果没有识别到微信号，则使用电话号码
        if (!$weChat) {
            return $this->getMobile();
        }

        return $weChat;
    }

}
