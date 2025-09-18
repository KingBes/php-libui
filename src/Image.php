<?php

namespace Kingbes\Libui;

use FFI\CData;

class Image extends Base
{

    /**
     * 创建图片
     *
     * @param float $width 图片宽度
     * @param float $height 图片高度
     * @return CData 图片句柄
     */
    public static function create(float $width, float $height): CData
    {
        return self::ffi()->uiNewImage($width, $height);
    }

    /**
     * 释放图片
     *
     * @param CData $image 图片句柄
     * @return void
     */
    public static function free(CData $image): void
    {
        self::ffi()->uiFreeImage($image);
    }

    /**
     * 追加图片数据
     *
     * @param CData $image 图片句柄
     * @param string $pathFile 图片路径
     * @return void
     */
    public static function append(
        CData $image,
        string $pathFile
    ): void {
        $rgba = self::imageToRGBA($pathFile);
        if (!$rgba) throw new \Exception("仅支持 JPEG、PNG、GIF 格式的图片");
        $bin = self::ffi()->new("unsigned char[". strlen($rgba['bytes']) ."]");
        self::ffi()::memcpy($bin, $rgba['bytes'], strlen($rgba['bytes']));
        self::ffi()->uiImageAppend(
            $image,
            $bin,
            $rgba['width'],
            $rgba['height'],
            $rgba['width'] * 4 // 每个像素 4 字节 (RGBA)
        );
    }

    public static function imageToRGBA($filePath)
    {
        // 获取图片信息
        $info = getimagesize($filePath);
        if (!$info) return false;

        // 根据类型创建图像资源
        switch ($info['mime']) {
            case 'image/jpeg':
                $image = imagecreatefromjpeg($filePath);
                break;
            case 'image/png':
                $image = imagecreatefrompng($filePath);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($filePath);
                break;
            default:
                return false;
        }

        // 获取宽高
        $width = imagesx($image);
        $height = imagesy($image);

        // 创建新的真彩色图像（带 alpha 通道）
        $rgbaImage = imagecreatetruecolor($width, $height);

        // 保留 alpha 通道信息
        imagealphablending($rgbaImage, false);
        imagesavealpha($rgbaImage, true);

        // 填充透明背景
        $transparent = imagecolorallocatealpha($rgbaImage, 0, 0, 0, 127);
        imagefill($rgbaImage, 0, 0, $transparent);

        // 复制图像并保留透明度
        imagecopy($rgbaImage, $image, 0, 0, 0, 0, $width, $height);

        // 提取 RGBA 字节数据
        $rgbaBytes = '';
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                $color = imagecolorat($rgbaImage, $x, $y);
                $rgba = imagecolorsforindex($rgbaImage, $color);

                // 打包为 4 字节 (R, G, B, A)
                $rgbaBytes .= pack(
                    'C4',
                    $rgba['red'],
                    $rgba['green'],
                    $rgba['blue'],
                    127 - (int)($rgba['alpha'] / 2) // 转换 alpha (0-127 => 0-255)
                );
            }
        }

        // 清理资源
        imagedestroy($image);
        imagedestroy($rgbaImage);

        return [
            'width' => $width,
            'height' => $height,
            'bytes' => $rgbaBytes
        ];
    }
}
