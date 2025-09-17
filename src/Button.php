<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 按钮类
 */
class Button extends Base
{
    /**
     * 创建按钮
     *
     * @param string $text 按钮文本
     * @return CData
     */
    public static function create(string $text): CData
    {
        return self::ffi()->uiNewButton($text);
    }

    /**
     * 获取按钮文本
     *
     * @param CData $button 按钮句柄
     * @return string
     */
    public static function text(CData $button): string
    {
        return self::ffi()->uiButtonText($button);
    }

    /**
     * 设置按钮文本
     *
     * @param CData $button 按钮句柄
     * @param string $text 按钮文本
     * @return void
     */
    public static function setText(CData $button, string $text): void
    {
        self::ffi()->uiButtonSetText($button, $text);
    }

    /**
     * 点击按钮事件
     *
     * @param CData $button 按钮句柄
     * @param callable $callback 回调函数
     * @return void
     */
    public static function onClicked(CData $button, callable $callback): void
    {
        self::ffi()->uiButtonOnClicked($button, function ($b, $d) use ($callback, $button) {
            $callback($button);
        }, null);
    }

    /**
     * 设置字体按钮
     *
     * @param CData $b 字体按钮句柄
     * @param CData $desc 字体描述符
     * @return void
     */
    public static function font(CData $b, CData $desc): void
    {
        self::ffi()->uiFontButtonFont($b, $desc);
    }

    /**
     * 字体按钮字体改变事件
     *
     * @param CData $btn 字体按钮句柄
     * @param callable $callback 回调函数
     * @return void
     */
    public static function onFontChanged(CData $btn, callable $callback): void
    {
        self::ffi()->uiFontButtonOnChanged(
            $btn,
            function ($b, $d) use ($callback, $btn) {
                $callback($btn);
            },
            null
        );
    }

    /**
     * 创建字体按钮
     *
     * @return CData
     */
    public static function createFont(): CData
    {
        return self::ffi()->uiNewFontButton();
    }

    /**
     * 释放字体按钮
     *
     * @param CData $desc 字体描述符句柄
     * @return void
     */
    public static function freeFont(CData $desc): void
    {
        self::ffi()->uiFreeFontButtonFont($desc);
    }

    /**
     * 获取颜色按钮
     *
     * @param CData $btn 颜色按钮句柄
     * @return object
     */
    public static function color(CData $btn): object
    {
        $r = self::ffi()->new("double [1]");
        $g = self::ffi()->new("double [1]");
        $b = self::ffi()->new("double [1]");
        $a = self::ffi()->new("double [1]");
        self::ffi()->uiColorButtonColor($btn, $r, $g, $b, $a);
        return (object)["r" => $r[0], "g" => $g[0], "b" => $b[0], "a" => $a[0]];
    }

    /**
     * 设置颜色按钮颜色
     *
     * @param CData $btn 颜色按钮句柄
     * @param float $r 红色
     * @param float $g 绿色
     * @param float $b 蓝色
     * @param float $a 透明度
     * @return void
     */
    public static function setColor(CData $btn, float $r, float $g, float $b, float $a): void
    {
        self::ffi()->uiColorButtonSetColor($btn, $r, $g, $b, $a);
    }

    /**
     * 颜色按钮颜色改变事件
     *
     * @param CData $btn 颜色按钮句柄
     * @param callable $callback 回调函数
     * @return void
     */
    public static function colorOnChanged(CData $btn, callable $callback): void
    {
        self::ffi()->uiColorButtonOnChanged(
            $btn,
            function ($b, $d) use ($callback, $btn) {
                $callback($btn);
            },
            null
        );
    }

    /**
     * 创建颜色按钮
     *
     * @return CData
     */
    public static function createColor(): CData
    {
        return self::ffi()->uiNewColorButton();
    }
}
