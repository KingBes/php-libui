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
}
