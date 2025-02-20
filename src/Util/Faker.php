<?php

namespace Webguosai\Util;

use Webguosai\Helper\Arr;
use Webguosai\Helper\Str;

/**
 * faker假数据
 */
class Faker
{
    /**
     * 姓名
     *
     * @param null $sex
     * @return string
     */
    public static function name($sex = null)
    {
        return self::firstName() . self::lastName($sex);
    }

    public static function firstName()
    {
        return Arr::random([
            '李', '王', '张', '刘', '陈', '杨', '赵', '黄', '周', '吴',
            '徐', '孙', '胡', '朱', '高', '林', '何', '郭', '马', '罗',
            '梁', '宋', '郑', '谢', '韩', '唐', '冯', '于', '董', '萧',
            '程', '曹', '袁', '邓', '许', '傅', '沉', '曾', '彭', '吕',
            '苏', '卢', '蒋', '蔡', '贾', '丁', '林', '薛', '叶', '阎',
            '余', '潘', '杜', '戴', '夏', '钟', '汪', '田', '任', '姜',
            '范', '方', '石', '姚', '谭', '廖', '邹', '熊', '金', '陆',
            '郝', '孔', '白', '崔', '康', '毛', '邱', '秦', '江', '史',
            '顾', '侯', '邵', '孟', '龙', '万', '段', '雷', '钱', '汤',
            '尹', '黎', '易', '常', '武', '乔', '贺', '赖', '龚', '文',
            '庞', '樊', '兰', '殷', '施', '陶', '洪', '翟', '安', '颜',
            '倪', '严', '牛', '温', '芦', '季', '俞', '章', '鲁', '葛',
            '伍', '韦', '申', '尤', '毕', '聂', '丛', '焦', '向', '柳',
            '邢', '路', '岳', '齐', '沿', '梅', '莫', '庄', '辛', '管',
            '祝', '左', '涂', '谷', '祁', '时', '舒', '耿', '牟', '卜',
            '路', '詹', '关', '苗', '凌', '费', '纪', '靳', '盛', '童',
            '欧', '甄', '项', '曲', '成', '游', '阳', '裴', '席', '卫',
            '查', '屈', '鲍', '位', '覃', '霍', '翁', '隋', '植', '甘',
            '景', '薄', '单', '包', '司', '柏', '宁', '柯', '阮', '桂',
            '闵', '欧阳', '解', '强', '柴', '华', '车', '冉', '房', '边',
            '辜', '吉', '饶', '刁', '瞿', '戚', '丘', '古', '米', '池',
            '滕', '晋', '苑', '邬', '臧', '畅', '宫', '来', '嵺', '苟',
            '全', '褚', '廉', '简', '娄', '盖', '符', '奚', '木', '穆',
            '党', '燕', '郎', '邸', '冀', '谈', '姬', '屠', '连', '郜',
            '晏', '栾', '郁', '商', '蒙', '计', '喻', '揭', '窦', '迟',
            '宇', '敖', '糜', '鄢', '冷', '卓', '花', '仇', '艾', '蓝',
            '都', '巩', '稽', '井', '练', '仲', '乐', '虞', '卞', '封',
            '竺', '冼', '原', '官', '衣', '楚', '佟', '栗', '匡', '宗',
            '应', '台', '巫', '鞠', '僧', '桑', '荆', '谌', '银', '扬',
            '明', '沙', '薄', '伏', '岑', '习', '胥', '保', '和', '蔺',
            '虢'
        ]);
    }

    public static function lastName($sex = null)
    {
        $man = [
            '伟', '强', '磊', '洋', '勇', '军', '杰', '涛', '超', '明',
            '刚', '平', '辉', '鹏', '华', '飞', '鑫', '波', '斌', '宇',
            '浩', '凯', '健', '俊', '帆', '帅', '旭', '宁', '龙', '林',
            '欢', '阳', '建华', '亮', '成', '畅', '建', '峰', '建国', '建军',
            '晨', '瑞', '志强', '兵', '雷', '东', '欣', '博', '彬', '坤',
            '全安', '荣', '岩', '杨', '文', '利', '楠', '建平', '嘉俊', '晧',
            '建明', '子安', '新华', '鹏程', '学明', '博涛', '捷', '文彬', '楼', '鹰',
            '松', '伦', '超', '钟', '瑜', '振国', '洪', '毅', '昱然', '哲',
            '翔', '翼', '祥', '国庆', '哲彦', '正诚', '正豪', '正平', '正业', '志诚',
            '志新', '志勇', '志明', '志强', '志文', '致远', '智明', '智勇', '智敏', '智渊',
            '赛'
        ];

        $woman = [
            '芳', '娜', '敏', '静', '敏静', '秀英', '丽', '洋', '艳', '娟',
            '文娟', '君', '文君', '珺', '霞', '明霞', '秀兰', '燕', '芬', '桂芬',
            '玲', '桂英', '丹', '萍', '华', '红', '玉兰', '桂兰', '英', '梅',
            '莉', '秀珍', '雪', '依琳', '旭', '宁', '婷', '馨予', '玉珍', '凤英',
            '晶', '欢', '玉英', '颖', '红梅', '佳', '倩', '琴', '兰英', '云',
            '洁', '爱华', '淑珍', '春梅', '海燕', '晨', '冬梅', '秀荣', '瑞', '桂珍',
            '莹', '秀云', '桂荣', '秀梅', '丽娟', '婷婷', '玉华', '琳', '雪梅', '淑兰',
            '丽丽', '玉', '秀芳', '欣', '淑英', '桂芳', '丽华', '丹丹', '桂香', '淑华',
            '秀华', '桂芝', '小红', '金凤', '文', '利', '楠', '红霞', '瑜', '桂花',
            '璐', '凤兰', '腊梅', '瑶', '嘉', '怡', '冰冰', '玉梅', '慧', '婕',
        ];

        if (is_null($sex)) {
            $sex = self::sex();
        }

        if ($sex === '女') {
            return Arr::random($woman);
        }
        return Arr::random($man);
    }

    public static function sex()
    {
        return Arr::random(['男', '女']);
    }

    public static function age()
    {
        return mt_rand(18, 75);
    }

    public static function is()
    {
        return mt_rand(0, 1);
    }

    /**
     * 生成汉字
     * @param string $length 长度
     * @param bool $isCommonly 是否常用字
     * @return false|string
     */
    public static function chinese($length = 6, $isCommonly = true)
    {
        $str = '';
        if ($isCommonly) {
            for ($i = 1; $i < $length; ++$i) {
                $str .= chr(mt_rand(0xB0, 0xD6)) . chr(mt_rand(0xA1, 0xFE));
            }
        } else {
            for ($i = 1; $i < $length; ++$i) {
                $hi = mt_rand(0xB0, 0xF7);
                if ($hi === 0xD7) {
                    $low = mt_rand(0xA1, 0xFE);
                } else {
                    $low = mt_rand(0xA1, 0xF9);
                }
                $str .= chr($hi) . chr($low); // 拼凑出一个gb2312编码的汉字
            }
        }
        return iconv('gb2312', 'utf-8', $str); // 将gb2312编码的全部汉字转换为utf-8
    }

    public static function school($suffix = '大学')
    {
        return Arr::random([
                '北京', '天津', '河北', '山西',
                '内蒙古', '辽宁', '吉林',
                '黑龙江', '上海', '江苏',
                '浙江', '安徽', '福建', '江西',
                '山东', '河南', '湖北', '湖南',
                '广东', '广西壮族自治区', '海南',
                '重庆', '四川', '贵州', '云南',
                '西藏', '陕西', '甘肃', '青海',
                '宁夏', '新疆',
                '香港', '澳门', '台湾'
            ]) . $suffix;
    }

    public static function company()
    {
        $companyArr = [
            '超艺', '和泰', '九方', '鑫博腾飞', '戴硕电子',
            '济南亿次元', '海创', '创联世纪', '凌云', '泰麒麟',
            '彩虹', '兰金电子', '晖来计算机', '天益', '恒聪百汇',
            '菊风公司', '惠派国际公司', '创汇', '思优', '时空盒数字',
            '易动力', '飞海科技', '华泰通安', '盟新', '商软冠联',
            '图龙信息', '易动力', '华远软件', '创亿', '时刻',
            '开发区世创', '明腾', '良诺', '天开', '毕博诚', '快讯',
            '凌颖信息', '黄石金承', '恩悌', '雨林木风计算机',
            '双敏电子', '维旺明', '网新恒天', '数字100', '飞利信',
            '立信电子', '联通时科', '中建创业', '新格林耐特',
            '新宇龙信息', '浙大万朋', 'MBP软件', '昂歌信息',
            '万迅电脑', '方正科技', '联软', '七喜', '南康', '银嘉',
            '巨奥', '佳禾', '国讯', '信诚致远', '浦华众城', '迪摩',
            '太极', '群英', '合联电子', '同兴万点', '襄樊地球村',
            '精芯', '艾提科信', '昊嘉', '鸿睿思博', '四通', '富罳',
            '商软冠联', '诺依曼软件', '东方峻景', '华成育卓', '趋势',
            '维涛', '通际名联'
        ];

        $suffix = ['科技', '网络', '信息', '传媒'];

        return Arr::random($companyArr) . Arr::random($suffix) . '有限公司';
    }

    public static function bank()
    {
        return Arr::random([
            '渤海银行',
            '广发银行',
            '国家开发银行',
            '恒丰银行',
            '华夏银行',
            '交通银行',
            '平安银行',
            '上海浦东发展银行',
            '兴业银行',
            '招商银行',
            '浙商银行',
            '中国工商银行',
            '中国光大银行',
            '中国建设银行',
            '中国民生银行',
            '中国农业银行',
            '中国银行',
            '中国邮政储蓄银行',
            '中信银行',
        ]);
    }

    public static function country()
    {
        return Arr::random([
            '阿富汗', '阿拉斯加', '阿尔巴尼亚', '阿尔及利亚',
            '安道尔', '安哥拉', '安圭拉岛英', '安提瓜和巴布达',
            '阿根廷', '亚美尼亚', '阿鲁巴岛', '阿森松', '澳大利亚',
            '奥地利', '阿塞拜疆', '巴林', '孟加拉国', '巴巴多斯',
            '白俄罗斯', '比利时', '伯利兹', '贝宁', '百慕大群岛',
            '不丹', '玻利维亚', '波斯尼亚和黑塞哥维那', '博茨瓦纳',
            '巴西', '保加利亚', '布基纳法索', '布隆迪', '喀麦隆',
            '加拿大', '加那利群岛', '佛得角', '开曼群岛', '中非',
            '乍得', '智利', '圣诞岛', '科科斯岛', '哥伦比亚',
            '巴哈马国', '多米尼克国', '科摩罗', '刚果', '科克群岛',
            '哥斯达黎加', '克罗地亚', '古巴', '塞浦路斯', '捷克',
            '丹麦', '迪戈加西亚岛', '吉布提', '多米尼加共和国',
            '厄瓜多尔', '埃及', '萨尔瓦多', '赤道几内亚',
            '厄立特里亚', '爱沙尼亚', '埃塞俄比亚', '福克兰群岛',
            '法罗群岛', '斐济', '芬兰', '法国', '法属圭亚那',
            '法属波里尼西亚', '加蓬', '冈比亚', '格鲁吉亚', '德国',
            '加纳', '直布罗陀', '希腊', '格陵兰岛', '格林纳达',
            '瓜德罗普岛', '关岛', '危地马拉', '几内亚', '几内亚比绍',
            '圭亚那', '海地', '夏威夷', '洪都拉斯', '匈牙利', '冰岛',
            '印度', '印度尼西亚', '伊郎', '伊拉克', '爱尔兰', '以色列',
            '意大利', '科特迪瓦', '牙买加', '日本', '约旦', '柬埔塞',
            '哈萨克斯坦', '肯尼亚', '基里巴斯', '朝鲜', '韩国', '科威特',
            '吉尔吉斯斯坦', '老挝', '拉脱维亚', '黎巴嫩', '莱索托',
            '利比里亚', '利比亚', '列支敦士登', '立陶宛', '卢森堡',
            '马其顿', '马达加斯加', '马拉维', '马来西亚', '马尔代夫',
            '马里', '马耳他', '马里亚纳群岛', '马绍尔群岛', '马提尼克',
            '毛里塔尼亚', '毛里求斯', '马约特岛', '墨西哥', '密克罗尼西亚',
            '中途岛', '摩尔多瓦', '摩纳哥', '蒙古', '蒙特塞拉特岛',
            '摩洛哥', '莫桑比克', '缅甸', '纳米比亚', '瑙鲁', '尼泊尔',
            '荷兰', '荷属安的列斯群岛', '新喀里多尼亚群岛', '新西兰',
            '尼加拉瓜', '尼日尔', '尼日利亚', '纽埃岛', '诺福克岛',
            '挪威', '阿曼', '帕劳', '巴拿马', '巴布亚新几内亚', '巴拉圭',
            '秘鲁', '菲律宾', '波兰', '葡萄牙', '巴基斯坦', '波多黎各',
            '卡塔尔', '留尼汪岛', '罗马尼亚', '俄罗斯', '卢旺达',
            '东萨摩亚', '西萨摩亚', '圣马力诺', '圣皮埃尔岛及密克隆岛',
            '圣多美和普林西比', '沙特阿拉伯', '塞内加尔', '塞舌尔',
            '新加坡', '斯洛伐克', '斯洛文尼亚', '所罗门群岛', '索马里',
            '南非', '西班牙', '斯里兰卡', '圣克里斯托弗和尼维斯',
            '圣赫勒拿', '圣卢西亚', '圣文森特岛', '苏丹', '苏里南',
            '斯威士兰', '瑞典', '瑞士', '叙利亚', '塔吉克斯坦', '坦桑尼亚',
            '泰国', '阿拉伯联合酋长国', '多哥', '托克劳群岛', '汤加',
            '特立尼达和多巴哥', '突尼斯', '土耳其', '土库曼斯坦',
            '特克斯和凯科斯群岛(', '图瓦卢', '美国', '乌干达', '乌克兰',
            '英国', '乌拉圭', '乌兹别克斯坦', '瓦努阿图', '梵蒂冈',
            '委内瑞拉', '越南', '维尔京群岛', '维尔京群岛和圣罗克伊',
            '威克岛', '瓦里斯和富士那群岛', '西撒哈拉', '也门', '南斯拉夫',
            '扎伊尔', '赞比亚', '桑给巴尔', '津巴布韦', '中华人民共和国', '中国'
        ]);
    }

    public static function region($separate = ' ')
    {
        return implode($separate, [
            '中国', self::city(), self::area()
        ]);
    }

    public static function province()
    {
        return Arr::random([
            '北京市', '天津市', '河北省', '山西省',
            '内蒙古自治区', '辽宁省', '吉林省',
            '黑龙江省', '上海市', '江苏省',
            '浙江省', '安徽省', '福建省', '江西省',
            '山东省', '河南省', '湖北省', '湖南省',
            '广东省', '广西壮族自治区', '海南省',
            '重庆市', '四川省', '贵州省', '云南省',
            '西藏自治区', '陕西省', '甘肃省', '青海省',
            '宁夏回族自治区', '新疆维吾尔自治区',
            '香港特别行政区', '澳门特别行政区', '台湾省'
        ]);
    }

    public static function city()
    {
        return Arr::random([
            '北京', '上海', '天津', '重庆',
            '哈尔滨', '长春', '沈阳', '呼和浩特',
            '石家庄', '乌鲁木齐', '兰州', '西宁',
            '西安', '银川', '郑州', '济南',
            '太原', '合肥', '武汉', '长沙',
            '南京', '成都', '贵阳', '昆明',
            '南宁', '拉萨', '杭州', '南昌',
            '广州', '福州', '海口',
            '香港', '澳门'
        ]);
    }

    public static function area()
    {
        return Arr::random([
            '西夏区', '永川区', '秀英区', '高港区',
            '清城区', '兴山区', '锡山区', '清河区',
            '龙潭区', '华龙区', '海陵区', '滨城区',
            '东丽区', '高坪区', '沙湾区', '平山区',
            '城北区', '海港区', '沙市区', '双滦区',
            '长寿区', '山亭区', '南湖区', '浔阳区',
            '南长区', '友好区', '安次区', '翔安区',
            '沈河区', '魏都区', '西峰区', '萧山区',
            '金平区', '沈北新区', '孝南区', '上街区',
            '城东区', '牧野区', '大东区', '白云区',
            '花溪区', '吉利区', '新城区', '怀柔区',
            '六枝特区', '涪城区', '清浦区', '南溪区',
            '淄川区', '高明区', '金水区', '中原区',
            '高新开发区', '经济开发新区', '新区'
        ]);
    }

    /**
     * 电话
     * @return string
     */
    public static function mobile()
    {
        return '1' . Arr::random([3, 4, 5, 6, 7, 8, 9]) . Str::padding(mt_rand(1, 999999999), 9, '0');
    }

    /**
     * 身份证号
     * @return string
     */
    public static function idCard()
    {
        return '43' .
            Str::padding(mt_rand(1, 9999), 4) .
            mt_rand(1920, date('Y')) .
            Str::padding(mt_rand(1, 12)) .
            Str::padding(mt_rand(1, 31)) .
            Str::padding(mt_rand(1, 999)) .
            Arr::random([0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'X', 'x']);
    }

    public static function website()
    {
        $domain   = [
            'taobao.com', 'baidu.com', 'douyin.com', '126.com', '163.com', 'qq.com', 'sohu.com', 'sina.com'
        ];
        $tld      = [
            'com', 'com', 'com', 'com', 'com', 'com', 'biz', 'info', 'net', 'org', 'cn',
            'com.cn', 'edu.cn', 'net.cn', 'biz.cn', 'gov.cn', 'org.cn'
        ];
        $protocol = [
            'http', 'https'
        ];
        return Arr::random($protocol) . '://' .
            Arr::random($domain) . '.' .
            Arr::random($tld);
    }

    public static function url()
    {
        return self::website();
    }

    public static function html()
    {
        $html = '<p>' . self::title() . '</p><p><h3>h3</h3></p><p><img src="' . self::imageUrl() . '"/></p><hr/><p><ul> <li>li 111</li> <li>li 222</li> <li>li 333</li></ul></p><p>pppppppp <a href="#">aaaaa</a> <b>bbbbbb</b><i>iiiii</i></p><table><thead><tr><th>name</th><th>age</th></tr></thead><tbody><tr><td>' . self::name() . '</td><td>' . self::age() . '</td></tr><tr><td>' . self::name() . '</td><td>' . self::age() . '</td></tr></tbody></table>';
        return $html;
    }

    public static function imageUrl($width = null, $height = null)
    {
        if ($width === null) {
            $width = self::number(100, 1000);
        }
        if ($height === null) {
            $height = self::number(100, 1000);
        }
        return 'https://dummyimage.com/' . $width . 'x' . $height . '.png/' . self::number(100000, 999999) . '/fff'; // fff 表示文字白色颜色
    }

    public static function email()
    {
        $domain = [
            'taobao.com', 'baidu.com', 'douyin.com', '126.com', '163.com', 'qq.com', 'sohu.com', 'sina.com'
        ];

        return self::account() . '@' . Arr::random($domain);
    }

    public static function account($min = 6, $max = 18)
    {
        return Str::lower(Str::random(mt_rand($min, $max), 5));
    }

    public static function ip()
    {
        // 国内 ipv4
        return Ip::getChinaRandom();
    }

    public static function color()
    {
        $color = str_pad(dechex(mt_rand(0, 255)), 3, '0', STR_PAD_LEFT);

        return '#' . $color[0] . $color[0] . $color[1] . $color[1] . $color[2] . $color[2];
    }

    public static function title($length = null)
    {
        $before = [
            '曾经说过',
            '在不经意间这样说过',
            '说过一句著名的话',
            '曾经提到过',
            '说过一句富有哲理的话'
        ];

        $after = [
            '这不禁令我深思. ',
            '带着这句话, 我们还要更加慎重的审视这个问题: ',
            '这启发了我. ',
            '我希望诸位也能好好地体会这句话. ',
            '这句话语虽然很短, 但令我浮想联翩. ',
            '这句话看似简单，但其中的阴郁不禁让人深思. ',
            '这句话把我们带到了一个新的维度去思考这个问题: ',
            '这似乎解答了我的疑惑. '
        ];

        $content = [
            '爱迪生a，天才是百分之一的勤奋加百分之九十九的汗水。b',
            '查尔斯·史a，一个人几乎可以在任何他怀有无限热忱的事情上成功。b',
            '培根说过，深窥自己的心，而后发觉一切的奇迹在你自己。b',
            '歌德曾经a，流水在碰到底处时才会释放活力。b',
            '莎士比亚a，那脑袋里的智慧，就像打火石里的火花一样，不去打它是不肯出来的。b',
            '戴尔·卡耐基a，多数人都拥有自己不了解的能力和机会，都有可能做到未曾梦想的事情。b',
            '白哲特a，坚强的信念能赢得强者的心，并使他们变得更坚强。b',
            '伏尔泰a, 不经巨大的困难，不会有伟大的事业。b',
            '富勒曾经a, 苦难磨炼一些人，也毁灭另一些人。b',
            '文森特·皮尔a, 改变你的想法，你就改变了自己的世界。b',
            '拿破仑·希尔a, 不要等待，时机永远不会恰到好处。b',
            '塞涅卡a, 生命如同寓言，其价值不在与长短，而在与内容。b',
            '奥普拉·温弗瑞a, 你相信什么，你就成为什么样的人。b',
            '吕凯特a, 生命不可能有两次，但许多人连一次也不善于度过。b',
            '莎士比亚a, 人的一生是短的，但如果卑劣地过这一生，就太长了。b',
            '笛卡儿a, 我的努力求学没有得到别的好处，只不过是愈来愈发觉自己的无知。b',
            '左拉a, 生活的道路一旦选定，就要勇敢地走到底，决不回头。b',
            '米歇潘a, 生命是一条艰险的峡谷，只有勇敢的人才能通过。b',
            '吉姆·罗恩a, 要么你主宰生活，要么你被生活主宰。b',
            '日本谚语a, 不幸可能成为通向幸福的桥梁。b',
            '海贝尔a, 人生就是学校。在那里，与其说好的教师是幸福，不如说好的教师是不幸。b',
            '杰纳勒尔·乔治·S·巴顿a, 接受挑战，就可以享受胜利的喜悦。b',
            '德谟克利特a, 节制使快乐增加并使享受加强。b',
            '裴斯泰洛齐a, 今天应做的事没有做，明天再早也是耽误了。b',
            '歌德a, 决定一个人的一生，以及整个命运的，只是一瞬之间。b',
            '卡耐基a, 一个不注意小事情的人，永远不会成就大事业。b',
            '卢梭a, 浪费时间是一桩大罪过。b',
            '康德a, 既然我已经踏上这条道路，那么，任何东西都不应妨碍我沿着这条路走下去。b',
            '克劳斯·莫瑟爵士a, 教育需要花费钱，而无知也是一样。b',
            '伏尔泰a, 坚持意志伟大的事业需要始终不渝的精神。b',
            '亚伯拉罕·林肯a, 你活了多少岁不算什么，重要的是你是如何度过这些岁月的。b',
            '韩非a, 内外相应，言行相称。b',
            '富兰克林a, 你热爱生命吗？那么别浪费时间，因为时间是组成生命的材料。b',
            '马尔顿a, 坚强的信心，能使平凡的人做出惊人的事业。b',
            '笛卡儿a, 读一切好书，就是和许多高尚的人谈话。b',
            '塞涅卡a, 真正的人生，只有在经过艰难卓绝的斗争之后才能实现。b',
            '易卜生a, 伟大的事业，需要决心，能力，组织和责任感。b',
            '歌德a, 没有人事先了解自己到底有多大的力量，直到他试过以后才知道。b',
            '达尔文a, 敢于浪费哪怕一个钟头时间的人，说明他还不懂得珍惜生命的全部价值。b',
            '佚名a, 感激每一个新的挑战，因为它会锻造你的意志和品格。b',
            '奥斯特洛夫斯基a, 共同的事业，共同的斗争，可以使人们产生忍受一切的力量。　b',
            '苏轼a, 古之立大事者，不惟有超世之才，亦必有坚忍不拔之志。b',
            '王阳明a, 故立志者，为学之心也；为学者，立志之事也。b',
            '歌德a, 读一本好书，就如同和一个高尚的人在交谈。b',
            '乌申斯基a, 学习是劳动，是充满思想的劳动。b',
            '别林斯基a, 好的书籍是最贵重的珍宝。b',
            '富兰克林a, 读书是易事，思索是难事，但两者缺一，便全无用处。b',
            '鲁巴金a, 读书是在别人思想的帮助下，建立起自己的思想。b',
            '培根a, 合理安排时间，就等于节约时间。b',
            '屠格涅夫a, 你想成为幸福的人吗？但愿你首先学会吃得起苦。b',
            '莎士比亚a, 抛弃时间的人，时间也抛弃他。b',
            '叔本华a, 普通人只想到如何度过时间，有才能的人设法利用时间。b',
            '博a, 一次失败，只是证明我们成功的决心还够坚强。 维b',
            '拉罗什夫科a, 取得成就时坚持不懈，要比遭到失败时顽强不屈更重要。b',
            '莎士比亚a, 人的一生是短的，但如果卑劣地过这一生，就太长了。b',
            '俾斯麦a, 失败是坚忍的最后考验。b',
            '池田大作a, 不要回避苦恼和困难，挺起身来向它挑战，进而克服它。b',
            '莎士比亚a, 那脑袋里的智慧，就像打火石里的火花一样，不去打它是不肯出来的。b',
            '希腊a, 最困难的事情就是认识自己。b',
            '黑塞a, 有勇气承担命运这才是英雄好汉。b',
            '非洲a, 最灵繁的人也看不见自己的背脊。b',
            '培根a, 阅读使人充实，会谈使人敏捷，写作使人精确。b',
            '斯宾诺莎a, 最大的骄傲于最大的自卑都表示心灵的最软弱无力。b',
            '西班牙a, 自知之明是最难得的知识。b',
            '塞内加a, 勇气通往天堂，怯懦通往地狱。b',
            '赫尔普斯a, 有时候读书是一种巧妙地避开思考的方法。b',
            '笛卡儿a, 阅读一切好书如同和过去最杰出的人谈话。b',
            '邓拓a, 越是没有本领的就越加自命不凡。b',
            '爱尔兰a, 越是无能的人，越喜欢挑剔别人的错儿。b',
            '老子a, 知人者智，自知者明。胜人者有力，自胜者强。b',
            '歌德a, 意志坚强的人能把世界放在手中像泥块一样任意揉捏。b',
            '迈克尔·斯特利a, 最具挑战性的挑战莫过于提升自我。b',
            '爱迪生a, 失败也是我需要的，它和成功对我一样有价值。b',
            '罗素·贝克a, 一个人即使已登上顶峰，也仍要自强不息。b',
            '马云a, 最大的挑战和突破在于用人，而用人最大的突破在于信任人。b',
            '雷锋a, 自己活着，就是为了使别人过得更美好。b',
            '布尔沃a, 要掌握书，莫被书掌握；要为生而读，莫为读而生。b',
            '培根a, 要知道对好事的称颂过于夸大，也会招来人们的反感轻蔑和嫉妒。b',
            '莫扎特a, 谁和我一样用功，谁就会和我一样成功。b',
            '马克思a, 一切节省，归根到底都归结为时间的节省。b',
            '莎士比亚a, 意志命运往往背道而驰，决心到最后会全部推倒。b',
            '卡莱尔a, 过去一切时代的精华尽在书中。b',
            '培根a, 深窥自己的心，而后发觉一切的奇迹在你自己。b',
            '罗曼·罗兰a, 只有把抱怨环境的心情，化为上进的力量，才是成功的保证。b',
            '孔子a, 知之者不如好之者，好之者不如乐之者。b',
            '达·芬奇a, 大胆和坚定的决心能够抵得上武器的精良。b',
            '叔本华a, 意志是一个强壮的盲人，倚靠在明眼的跛子肩上。b',
            '黑格尔a, 只有永远躺在泥坑里的人，才不会再掉进坑里。b',
            '普列姆昌德a, 希望的灯一旦熄灭，生活刹那间变成了一片黑暗。b',
            '维龙a, 要成功不需要什么特别的才能，只要把你能做的小事做得好就行了。b',
            '郭沫若a, 形成天才的决定因素应该是勤奋。b',
            '洛克a, 学到很多东西的诀窍，就是一下子不要学很多。b',
            '西班牙a, 自己的鞋子，自己知道紧在哪里。b',
            '拉罗什福科a, 我们唯一不会改正的缺点是软弱。b',
            '亚伯拉罕·林肯a, 我这个人走得很慢，但是我从不后退。b',
            '美华纳a, 勿问成功的秘诀为何，且尽全力做你应该做的事吧。b',
            '俾斯麦a, 对于不屈不挠的人来说，没有失败这回事。b',
            '阿卜·日·法拉兹a, 学问是异常珍贵的东西，从任何源泉吸收都不可耻。b',
            '白哲特a, 坚强的信念能赢得强者的心，并使他们变得更坚强。 b',
            '查尔斯·史考伯a, 一个人几乎可以在任何他怀有无限热忱的事情上成功。 b',
            '贝多芬a, 卓越的人一大优点是：在不利与艰难的遭遇里百折不饶。b',
            '莎士比亚a, 本来无望的事，大胆尝试，往往能成功。b',
            '卡耐基a, 我们若已接受最坏的，就再没有什么损失。b',
            '德国a, 只有在人群中间，才能认识自己。b',
            '史美尔斯a, 书籍把我们引入最美好的社会，使我们认识各个时代的伟大智者。b',
            '冯学峰a, 当一个人用工作去迎接光明，光明很快就会来照耀着他。b',
            '吉格·金克拉a, 如果你能做梦，你就能实现它。b'
        ];

        $title = str_replace(['a', 'b'], [Arr::random($before), Arr::random($after)], Arr::random($content));

        if (!is_null($length)) {
            $title = Str::substr($title, 0, $length);
        }

        return $title;
    }

    public static function question()
    {
        $question = [
            '什么东西天气越热，它爬的越高',
            '什么动物，你打死了它却流了你的血',
            '谁天天去看病',
            '什么照片看不出照的是谁',
            '一对健康的夫妇，为什么会生出一个没有眼睛的后代',
            '什么布剪不断',
            '为什么鸡会吃沙粒',
            '信鸽为什么不会迷路',
            '小猫的胡子有什么不同',
            '牛羊不吃草时嘴为什么还在动'
        ];

        return Arr::random($question) . '?';
    }

    public static function news()
    {
        return Arr::random([
            '方直科技拟以自有资金1.2亿元共同投资设立嘉道方直投资基金',
            '2016年9月1日学生总人数31788人，较去年同期的27644人，增加了15%。',
            '刚刚过去的这一周教育圈又发生了哪些事情？一起随着多知网回顾一下吧。',
            '今天下午，腾讯课堂举行TOP计划发布会，并发布了“机构认证计划”，为16家教育机构颁布认证。',
            '原“速算盒子”更名为“作业盒子小学”。',
            '新模式探索：大型旗舰店+微型社区店。',
            '业绩预告显示，方直科技预计归属于上市公司股东的净利润同向下降。',
            '长期以来，科学一直被认为是人类不可能外包给机器人的，但这种观念正在改变。',
            '优达学城、北风网等均已上线人工智能课程',
            '印度在线教育平台BYJU获得7500万美元投资，投资方为印度红杉资本和Sofina。'
        ]);
    }

    public static function password($length = 8)
    {
        return Str::random($length, false, '~!@#$%^&*+-');
    }

    public static function number($min = 1, $max = 20)
    {
        return mt_rand($min, $max);
    }

    /**
     * 日期时间
     *
     * @param string $startDateTime 最小日期时间
     * @param string $endDateTime 最大日期时间
     * @return false|string
     */
    public static function datetime($startDateTime = '1992-01-01 00:00:00', $endDateTime = '2092-01-01 00:00:00')
    {
        [$t1, $t2] = Date::getStartEndUnix($startDateTime, $endDateTime);

        return date('Y-m-d H:i:s', mt_rand($t1, $t2));
    }

    public static function date($startDate = '1992-01-01', $endDate = '2092-01-01')
    {
        [$t1, $t2] = Date::getStartEndUnix($startDate, $endDate);

        return date('Y-m-d', mt_rand($t1, $t2));
    }

    public static function time($start = '00:00:01', $end = '23:59:59')
    {
        [$t1, $t2] = Date::getStartEndUnix($start, $end);

        return date('H:i:s', mt_rand($t1, $t2));
    }

    public static function ids($length = 2, $min = 1, $max = 20)
    {
        $idArr = [];

        for ($i = 0; $i < $length; $i++) {
            $idArr[] = self::number($min, $max);
        }

        return Arr::implode(Arr::filterUnique($idArr));
    }

    public static function price($point = 2, $min = 1, $max = 100)
    {
        return (float)(self::number($min, $max) . '.' . Str::padding('', $point, self::number(1, 9)));
    }

    public static function currency()
    {
        return Arr::random([
            'AED', 'AFN', 'ALL', 'AMD', 'ANG', 'AOA', 'ARS', 'AUD', 'AWG', 'AZN', 'BAM', 'BBD', 'BDT', 'BGN', 'BHD', 'BIF', 'BMD', 'BND', 'BOB', 'BOV', 'BRL', 'BSD', 'BTN', 'BWP', 'BYR', 'BZD', 'CAD', 'CDF', 'CHE', 'CHF', 'CHW', 'CLF', 'CLP', 'CNY', 'COP', 'COU', 'CRC', 'CUC', 'CUP', 'CVE', 'CZK', 'DJF', 'DKK', 'DOP', 'DZD', 'EGP', 'ERN', 'ETB', 'EUR', 'FJD', 'FKP', 'GBP', 'GEL', 'GHS', 'GIP', 'GMD', 'GNF', 'GTQ', 'GYD', 'HKD', 'HNL', 'HRK', 'HTG', 'HUF', 'IDR', 'ILS', 'INR', 'IQD', 'IRR', 'ISK', 'JMD', 'JOD', 'JPY', 'KES', 'KGS', 'KHR', 'KMF', 'KPW', 'KRW', 'KWD', 'KYD', 'KZT', 'LAK', 'LBP', 'LKR', 'LRD', 'LSL', 'LYD', 'MAD', 'MDL', 'MGA', 'MKD', 'MMK', 'MNT', 'MOP', 'MRO', 'MUR', 'MVR', 'MWK', 'MXN', 'MXV', 'MYR', 'MZN', 'NAD', 'NGN', 'NIO', 'NOK', 'NPR', 'NZD', 'OMR', 'PAB', 'PEN', 'PGK', 'PHP', 'PKR', 'PLN', 'PYG', 'QAR', 'RON', 'RSD', 'RUB', 'RWF', 'SAR', 'SBD', 'SCR', 'SDG', 'SEK', 'SGD', 'SHP', 'SLL', 'SOS', 'SRD', 'SSP', 'STD', 'SYP', 'SZL', 'THB', 'TJS', 'TMT', 'TND', 'TOP', 'TRY', 'TTD', 'TWD', 'TZS', 'UAH', 'UGX', 'USD', 'USN', 'USS', 'UYI', 'UYU', 'UZS', 'VEF', 'VND', 'VUV', 'WST', 'XAF', 'XAG', 'XAU', 'XBA', 'XBB', 'XBC', 'XBD', 'XCD', 'XDR', 'XFU', 'XOF', 'XPD', 'XPF', 'XPT', 'XSU', 'XTS', 'XUA', 'YER', 'ZAR', 'ZMW'
        ]);
    }

    public static function currencySymbol()
    {
        return Arr::random([
            '$', '￥', '€', '￡', '¤'
        ]);
    }

    public static function zip()
    {
        return Arr::random([
            410000, 412000, 411100,
            421200, 422000, 414000,
            415000, 427000, 413000,
            423000, 425000, 418000,
            417000, 416000
        ]);
    }

    public static function job()
    {
        return Arr::random([
            'Java', 'C++', 'PHP', 'C', 'C#', '.NET', 'Hadoop', 'Python', 'Delphi', 'VB', 'Perl', 'Ruby', 'Node.js', 'Golang', 'Erlang',
        ]);
    }

    public static function project()
    {
        return Arr::random([
            '公司二、三期建设项目', '信息科技基地新建项目', '总建筑面积88624二期项目', '建筑面积约100000平方米一期项目', '高新区医疗器械配套产业园项目', '特色产业聚集区建设项目', '雨花梨园项目', '福林雅苑项目', '建设治疗II型糖尿病的功能特化间充质干细胞制剂研发项目', '人民医院医疗综合楼建设项目', '果蔬初加工及冷链物流中心建设项目', '污水处理厂及配套管网建设项目', '总建筑面积27800m养老联合体项目', '16个小区2022年城市燃气管道等老化更新改造项目', '民族中医药学校项目', '职业技术实训基地项目', '社仓小学建设项目', '总建筑面积约2.3万平方米小学(一期)项目', '公司二、三期建设项目', '信息科技基地新建项目', '总建筑面积88624二期项目', '建筑面积约100000平方米一期项目', '高新区医疗器械配套产业园项目', '特色产业聚集区建设项目', '雨花梨园项目', '福林雅苑项目', '建设治疗II型糖尿病的功能特化间充质干细胞制剂研发项目', '人民医院医疗综合楼建设项目', '果蔬初加工及冷链物流中心建设项目', '污水处理厂及配套管网建设项目', '总建筑面积27800m养老联合体项目', '16个小区2022年城市燃气管道等老化更新改造项目', '社仓小学建设项目', '老旧小区改造配套基础设施项目', '民族中医药学校项目', '总建筑面积约2.3万平方米小学(一期)项目', '公司二、三期建设项目', '信息科技基地新建项目', '总建筑面积88624二期项目', '建筑面积约100000平方米一期项目', '高新区医疗器械配套产业园项目', '特色产业聚集区建设项目', '雨花梨园项目', '福林雅苑项目', '建设治疗II型糖尿病的功能特化间充质干细胞制剂研发项目', '人民医院医疗综合楼建设项目', '果蔬初加工及冷链物流中心建设项目', '污水处理厂及配套管网建设项目', '总建筑面积27800m养老联合体项目', '16个小区2022年城市燃气管道等老化更新改造项目', '社仓小学建设项目', '老旧小区改造配套基础设施项目', '民族中医药学校项目', '公司二、三期建设项目', '信息科技基地新建项目', '总建筑面积88624二期项目', '建筑面积约100000平方米一期项目', '高新区医疗器械配套产业园项目', '特色产业聚集区建设项目', '雨花梨园项目', '福林雅苑项目', '建设治疗II型糖尿病的功能特化间充质干细胞制剂研发项目', '人民医院医疗综合楼建设项目', '果蔬初加工及冷链物流中心建设项目', '污水处理厂及配套管网建设项目', '总建筑面积27800m养老联合体项目', '16个小区2022年城市燃气管道等老化更新改造项目', '民族中医药学校项目', '职业技术实训基地项目', '社仓小学建设项目', '总建筑面积约2.3万平方米小学(一期)项目', '公司二、三期建设项目', '信息科技基地新建项目', '总建筑面积88624二期项目', '建筑面积约100000平方米一期项目', '高新区医疗器械配套产业园项目', '特色产业聚集区建设项目', '雨花梨园项目', '福林雅苑项目', '建设治疗II型糖尿病的功能特化间充质干细胞制剂研发项目', '人民医院医疗综合楼建设项目', '果蔬初加工及冷链物流中心建设项目', '污水处理厂及配套管网建设项目', '总建筑面积27800m养老联合体项目', '16个小区2022年城市燃气管道等老化更新改造项目', '社仓小学建设项目', '老旧小区改造配套基础设施项目', '民族中医药学校项目', '公司二、三期建设项目', '信息科技基地新建项目', '总建筑面积88624二期项目', '建筑面积约100000平方米一期项目', '高新区医疗器械配套产业园项目', '特色产业聚集区建设项目', '雨花梨园项目', '福林雅苑项目', '建设治疗II型糖尿病的功能特化间充质干细胞制剂研发项目', '人民医院医疗综合楼建设项目', '果蔬初加工及冷链物流中心建设项目', '污水处理厂及配套管网建设项目', '总建筑面积27800m养老联合体项目', '16个小区2022年城市燃气管道等老化更新改造项目', '民族中医药学校项目', '职业技术实训基地项目', '社仓小学建设项目', '总建筑面积约2.3万平方米小学(一期)项目', '公司二、三期建设项目', '信息科技基地新建项目', '总建筑面积88624二期项目', '建筑面积约100000平方米一期项目', '高新区医疗器械配套产业园项目', '特色产业聚集区建设项目', '雨花梨园项目', '福林雅苑项目', '建设治疗II型糖尿病的功能特化间充质干细胞制剂研发项目', '人民医院医疗综合楼建设项目', '果蔬初加工及冷链物流中心建设项目', '污水处理厂及配套管网建设项目', '总建筑面积27800m养老联合体项目', '16个小区2022年城市燃气管道等老化更新改造项目', '社仓小学建设项目', '老旧小区改造配套基础设施项目', '民族中医药学校项目', '公司二、三期建设项目', '信息科技基地新建项目', '总建筑面积88624二期项目', '建筑面积约100000平方米一期项目', '高新区医疗器械配套产业园项目', '特色产业聚集区建设项目', '雨花梨园项目', '福林雅苑项目', '建设治疗II型糖尿病的功能特化间充质干细胞制剂研发项目', '人民医院医疗综合楼建设项目', '果蔬初加工及冷链物流中心建设项目', '污水处理厂及配套管网建设项目', '总建筑面积27800m养老联合体项目', '16个小区2022年城市燃气管道等老化更新改造项目', '民族中医药学校项目', '职业技术实训基地项目', '社仓小学建设项目', '总建筑面积约2.3万平方米小学(一期)项目', '公司二、三期建设项目', '信息科技基地新建项目', '总建筑面积88624二期项目', '建筑面积约100000平方米一期项目', '高新区医疗器械配套产业园项目', '特色产业聚集区建设项目', '雨花梨园项目', '福林雅苑项目', '建设治疗II型糖尿病的功能特化间充质干细胞制剂研发项目', '人民医院医疗综合楼建设项目', '果蔬初加工及冷链物流中心建设项目', '污水处理厂及配套管网建设项目', '总建筑面积27800m养老联合体项目', '16个小区2022年城市燃气管道等老化更新改造项目', '社仓小学建设项目', '老旧小区改造配套基础设施项目', '民族中医药学校项目',
        ]);
    }

    public static function car()
    {
        return Arr::random([
            '奔驰',
            '宝马',
            '本田',
            '丰田',
            '福特',
            '大众',
            '别克',
            '奥迪',
            '雪佛兰'
        ]);
    }

    public static function carLabel()
    {
        return Arr::random([
            '德系',
            '日系',
            '美系',
            '欧系',
            '国产'
        ]);
    }

    public static function carProject()
    {
        $suffix = [
            '的维修项目',
            '的保养项目',
            '的保险项目',
            '的生产项目',
            '的改造项目',
            '的投放项目',
        ];

        $tranche = [
            '一期',
            '二期',
            '三期',
        ];

        return self::province() . self::car() . Arr::random($tranche) . Arr::random($suffix);
    }

    public static function brand()
    {
        return Arr::random([
            '安踏',
            '李宁',
            '耐克',
            '阿迪达斯',
            '彪马',
        ]);
    }

    // 生成katex格式的公式代码
    public static function katex($symbol = '$')
    {
        return $symbol . '\frac{' . mt_rand(1, 100) . '}{' . mt_rand(100, 999) . '}' . $symbol;
    }

}
