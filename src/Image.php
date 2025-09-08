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
     * @param string $pixels 图片数据
     * @param int $pixelWidth 图片宽度
     * @param int $pixelHeight 图片高度
     * @return void
     */
    public static function append(
        CData $image,
        string $pathFile,
        int $pixelWidth,
        int $pixelHeight
    ): void {
        $byteStride = $pixelWidth * 4;
        $imageData = file_get_contents($pathFile);
        self::ffi()->uiImageAppend(
            $image,
            $imageData,
            $pixelWidth,
            $pixelHeight,
            $byteStride
        );
    }
}
