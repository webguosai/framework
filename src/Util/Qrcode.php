<?php

namespace Webguosai\Util;

use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode as BaseQr;
use Zxing\QrReader;

class Qrcode
{
    const SOURCE_TYPE_FILE     = QrReader::SOURCE_TYPE_FILE;
    const SOURCE_TYPE_BLOB     = QrReader::SOURCE_TYPE_BLOB;

    // 字体
    public static $font = __DIR__ . '/../../assets/font/simhei.ttf';

    /**
     * 生成二维码
     *
     * @param string $text
     * @param int $size
     * @param array $logo
     * @param array $label
     * @param int[] $foregroundColor 设置二维码颜色,默认为黑色
     * @param int[] $backgroundColor 设置二维码背景色,默认为白色
     * @return string
     */
    public static function create($text, $size = 300, $logo = [], $label = [], $foregroundColor = ['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0], $backgroundColor = ['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0])
    {
        $qrCode = new BaseQr($text);

        $qrCode->setSize($size);
        $qrCode->setEncoding('UTF-8');

        $qrCode->setMargin(10);

        // 设置容错等级
        $qrCode->setErrorCorrectionLevel(new ErrorCorrectionLevel(ErrorCorrectionLevel::HIGH));

        // 设置二维码颜色,默认为黑色
        $qrCode->setForegroundColor($foregroundColor);
        // 设置二维码背景色,默认为白色
        $qrCode->setBackgroundColor($backgroundColor);

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
     * 解码二维码
     *
     * @param string $file 二维码文件路径
     * @param mixed $type 类型(默认为文件路径)
     * @param bool $useImagickIfAvailable imagick如果可用，则使用它
     * @return mixed
     */
    public static function decode($file, $type = self::SOURCE_TYPE_FILE, $useImagickIfAvailable = true)
    {
        return (new QrReader($file, $type, $useImagickIfAvailable))->text();
    }

}
