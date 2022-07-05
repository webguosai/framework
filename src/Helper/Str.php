<?php

namespace Webguosai\Helper;

class Str
{
    protected static $snakeCache = [];
    protected static $camelCache = [];
    protected static $studlyCache = [];

    /**
     * 模板替换
     * Str::templateReplace('你好：{nickname}', ['nickname' => '张三'], true)
     *
     * @param string $string 模板内容
     * @param array $array 数组
     * @param bool $clearEmptyLabel 清除无用标签
     * @param string $leftLabel 左标签符号
     * @param string $rightLabel 右标签符号
     * @return string
     */
    public static function templateReplace(string $string, array $array, $clearEmptyLabel = false, $leftLabel = '{', $rightLabel = '}')
    {
        $search  = [];
        $replace = [];
        foreach ($array as $key => $value) {
            if (!is_array($value)) {
                $search[]  = $leftLabel . $key . $rightLabel;
                $replace[] = $value;
            }
        }

        $content = str_ireplace($search, $replace, $string);

        if ($clearEmptyLabel) {
            $content = preg_replace("/{$leftLabel}[^{$rightLabel}]*{$rightLabel}/i", '', $content);
        }

        return $content;
    }

    /**
     * 检查字符串中是否包含某些字符串
     * @param string $haystack 完整的内容,如：abc123abc
     * @param string|array $needles 需要的内容,如：123
     * @return bool
     */
    public static function contains(string $haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if ('' != $needle && mb_strpos($haystack, $needle) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * 检查字符串是否以某些字符串结尾
     *
     * @param string $haystack
     * @param string|array $needles
     * @return bool
     */
    public static function endsWith(string $haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if ((string)$needle === static::substr($haystack, -static::length($needle))) {
                return true;
            }
        }

        return false;
    }

    /**
     * 检查字符串是否以某些字符串开头
     *
     * @param string $haystack
     * @param string|array $needles
     * @return bool
     */
    public static function startsWith(string $haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if ('' != $needle && mb_strpos($haystack, $needle) === 0) {
                return true;
            }
        }

        return false;
    }

    /**
     * 获取指定长度的随机字母数字组合的字符串
     *
     * @param int $length
     * @param int $type
     * @param string $addChars
     * @return string
     */
    public static function random($length = 6, $type = null, $addChars = '')
    {
        $str = '';
        switch ($type) {
            case 0:
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz' . $addChars;
                break;
            case 1:
                $chars = str_repeat('0123456789', 3);
                break;
            case 2:
                $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' . $addChars;
                break;
            case 3:
                $chars = 'abcdefghijklmnopqrstuvwxyz' . $addChars;
                break;
            case 4:
                $chars = "们以我到他会作时要动国产的一是工就年阶义发成部民可出能方进在了不和有大这主中人上为来分生对于学下级地个用同行面说种过命度革而多子后自社加小机也经力线本电高量长党得实家定深法表着水理化争现所二起政三好十战无农使性前等反体合斗路图把结第里正新开论之物从当两些还天资事队批点育重其思与间内去因件日利相由压员气业代全组数果期导平各基或月毛然如应形想制心样干都向变关问比展那它最及外没看治提五解系林者米群头意只明四道马认次文通但条较克又公孔领军流入接席位情运器并飞原油放立题质指建区验活众很教决特此常石强极土少已根共直团统式转别造切九你取西持总料连任志观调七么山程百报更见必真保热委手改管处己将修支识病象几先老光专什六型具示复安带每东增则完风回南广劳轮科北打积车计给节做务被整联步类集号列温装即毫知轴研单色坚据速防史拉世设达尔场织历花受求传口断况采精金界品判参层止边清至万确究书" . $addChars;
                break;
            default:
                $chars = 'ABCDEFGHIJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz0123456789' . $addChars;
                break;
        }
        if ($length > 10) {
            $chars = $type == 1 ? str_repeat($chars, $length) : str_repeat($chars, 5);
        }
        if ($type != 4) {
            $chars = str_shuffle($chars);
            $str   = substr($chars, 0, $length);
        } else {
            for ($i = 0; $i < $length; $i++) {
                $str .= mb_substr($chars, floor(mt_rand(0, mb_strlen($chars, 'utf-8') - 1)), 1);
            }
        }
        return $str;
    }

    /**
     * 字符串转小写
     *
     * @param string $value
     * @return string
     */
    public static function lower(string $value)
    {
        return mb_strtolower($value, 'UTF-8');
    }

    /**
     * 字符串转大写
     *
     * @param string $value
     * @return string
     */
    public static function upper(string $value)
    {
        return mb_strtoupper($value, 'UTF-8');
    }

    /**
     * 获取字符串的长度
     *
     * @param string $value
     * @return int
     */
    public static function length(string $value)
    {
        return mb_strlen($value);
    }

    /**
     * 截取字符串
     *
     * @param string $string
     * @param int $start
     * @param int|null $length
     * @return string
     */
    public static function substr(string $string, int $start, int $length = null)
    {
        return mb_substr($string, $start, $length, 'UTF-8');
    }

    /**
     * 驼峰转下划线
     *
     * @param string $value
     * @param string $delimiter
     * @return string
     */
    public static function snake($value, $delimiter = '_')
    {
        $key = $value;

        if (isset(static::$snakeCache[$key][$delimiter])) {
            return static::$snakeCache[$key][$delimiter];
        }

        if (!ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', ucwords($value));

            $value = static::lower(preg_replace('/(.)(?=[A-Z])/u', '$1' . $delimiter, $value));
        }

        return static::$snakeCache[$key][$delimiter] = $value;
    }

    /**
     * 下划线转驼峰(首字母小写)
     *
     * @param string $value
     * @return string
     */
    public static function camel(string $value)
    {
        if (isset(static::$camelCache[$value])) {
            return static::$camelCache[$value];
        }

        return static::$camelCache[$value] = lcfirst(static::studly($value));
    }

    /**
     * 下划线转驼峰(首字母大写)
     *
     * @param string $value
     * @return string
     */
    public static function studly(string $value)
    {
        $key = $value;

        if (isset(static::$studlyCache[$key])) {
            return static::$studlyCache[$key];
        }

        $value = ucwords(str_replace(['-', '_'], ' ', $value));

        return static::$studlyCache[$key] = str_replace(' ', '', $value);
    }

    /**
     * 转为首字母大写的标题格式
     *
     * @param string $value
     * @return string
     */
    public static function title(string $value)
    {
        return mb_convert_case($value, MB_CASE_TITLE, 'UTF-8');
    }

    /**
     * 隐藏手机号
     * @param string|int $str 手机号码
     * @param int $start 开始位置，从0开始
     * @param int $length 隐藏长度
     * @return bool|string|string[]
     */
    public static function hidePhone($str, int $start = 3, int $length = 4)
    {
        //获取最后一位
        $end = $start + $length;
        //判断传参是否正确
        if ($start < 0 || $end > 11) return false;
        $replace = ''; //用于判断多少
        for ($i = 0; $i < $length; $i++) $replace .= '*';
        return substr_replace($str, $replace, $start, $length);
    }

    /**
     * 内容填充(仿str_pad函数)
     *
     * @param string $string 内容
     * @param int $length 填充长度
     * @param string $padString 填充的内容
     * @param int $padType 填充类型(默认为往左填充)
     * @return string
     */
    public static function padding($string, $length = 2, $padString = '0', $padType = STR_PAD_LEFT)
    {
        return str_pad($string, $length, $padString, $padType);
    }

    /**
     * 生成固定的短文本
     *
     * @param string $text
     * @return string
     */
    public static function shortText($text)
    {
        $x = sprintf("%u", crc32($text));

        $show = '';
        while ($x > 0) {
            $s = $x % 62;
            if ($s > 35) {
                $s = chr($s + 61);
            } elseif ($s > 9 && $s <= 35) {
                $s = chr($s + 55);
            }
            $show .= $s;
            $x    = floor($x / 62);
        }
        return $show;
    }

    /**
     * 将内容拆解为数组(支持中文)
     * 如： 123 => [1,2,3]
     *
     * @param string|array $string
     * @param int $length
     * @param null $encoding
     * @return array|string
     */
    public static function split($string, $length = 1, $encoding = null)
    {
        if (is_array($string)) {
            return $string;
        }

        return mb_str_split($string, $length, $encoding);
    }

}
