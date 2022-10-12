<?php

namespace Webguosai\Util;

use Webguosai\Helper\Str;

/**
 * 文本提取内容
 */
class TextExtract
{
    protected $text;

    public function __construct($text)
    {
        if (is_array($text)) {
            $text = implode("\n", $text);
        }

        // 全角转半角
        $this->text = Str::sbc2dbc($text);
    }

    /**
     * 姓名
     *
     * @return string
     */
    public function getName()
    {
        $name = '';
        $rex  = '#我(?:叫|姓)([\x{4e00}-\x{9fa5}]{2,4})#iu';
        if (preg_match($rex, $this->text, $mat)) {
            $name = $mat[1];
        }

        // 启用增加
//        if (!$name) {
//            $join = implode('|', $this->firstName);
//            $rex = '/((?:'.$join.')[\x{4e00}-\x{9fa5}]{1,2})/iu';
//            if (preg_match_all($rex, $this->text, $mat)) {
//                $name = $mat[1];
//            }
//        }

        return $name;
    }

    /**
     * 性别
     *
     * @return string
     */
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

    /**
     * 年龄
     *
     * @return int|null
     */
    public function getAge()
    {
        $age = null;

        if (preg_match('/(\d{1,2})岁/i', $this->text, $mat)) {
            $age = $mat[1];
        }

        return $age;
    }

    /**
     * 手机号
     *
     * @return array
     */
    public function getMobile()
    {
        $mobile = [];
        // 支持 136-3333-6666 这种格式
        $rex = '#[^\d]+(1[3-9][0-9]{1}[-]*[0-9]{4}[-]*[0-9]{4})#i';
        if (preg_match_all($rex, $this->text, $mat)) {
            $mobile = array_map(function ($value) {
                return str_replace('-', '', $value);
            }, $mat[1]);
        }

        return $mobile;
    }

    /**
     * 获取微信号
     *
     * @return array
     */
    public function getWeChat()
    {
        $weChat = [];
        $rex    = '#([a-zA-Z]{1}[a-zA-Z\d_-]{5,19})#i';
        $rex2   = '#([1-9]{1}[0-9]{4,11})#i';

        if (preg_match_all($rex, $this->text, $mat)) {
            //匹配微信号官方格式
            $weChat = $mat[1];
        } elseif (preg_match_all($rex2, $this->text, $mat)) {
            //匹配是否为QQ号，因为通过QQ号也能查找出微信号
            $weChat = $mat[1];
        }

        return $weChat;
    }

    /**
     * 获取身份证号
     *
     * @return array
     */
    public function getIdCard()
    {
        $idCard = [];
        // tp
//        $rex = '/([1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx])|([1-9]\d{5}\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{2})/';
        $rex = '/(?:[1-9]\d{5}(?:18|19|[23]\d)\d{2}(?:(?:0[1-9])|[10|11|12])(?:(?:[0-2][1-9])|10|20|30|31)\d{3}[0-9Xx])|(?:[1-9]\d{5}\d{2}(?:(?:0[1-9])|[10|11|12])(?:(?:[0-2][1-9])|10|20|30|31)\d{2})/';
        if (preg_match_all($rex, $this->text, $mat)) {
            $idCard = $mat[0];
        }

        return $idCard;
    }

}
