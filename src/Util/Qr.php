<?php

namespace Webguosai\Util;

use Endroid\QrCode\QrCode;
use Zxing\QrReader;

class Qr
{
    // 字体
    public static $font = __DIR__ . '/../../assets/font/simhei.ttf';

    /**
     * 生成二维码
     *
     * @param string $text
     * @param int $size
     * @param array $logo
     * @param array $label
     * @return string
     */
    public static function code($text, $size = 300, $logo = [], $label = [])
    {
        $qrCode = new QrCode($text);

        $qrCode->setSize($size);

        if ($logo) {
            $logoWidth = empty($logo['width']) ? 50 : empty($logo['width']);
            $logoHeight = empty($logo['height']) ? 50 : $logo['height'];
            $qrCode->setLogoPath($logo['file']);
            $qrCode->setLogoSize($logoWidth, $logoHeight);
        }

        if ($label) {
            $labelSize = empty($label['size']) ? 16 : $label['size'];
            $qrCode->setLabel($label['text'], $labelSize, self::$font);
        }

        return $qrCode;
    }

    /**
     * 读取二维码
     *
     * @param string $file 二维码文件路径
     * @return mixed
     */
    public static function read($file)
    {
        return (new QrReader($file))->text();
    }

}
