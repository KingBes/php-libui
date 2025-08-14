<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 复选框类
 */
class Checkbox extends Base
{
    /**
     * 获取复选框文本
     *
     * @param CData $checkbox 复选框句柄
     * @return string
     */
    public static function text(CData $checkbox): string
    {
        return self::ffi()->uiCheckboxText($checkbox);
    }

    /**
     * 设置复选框文本
     *
     * @param CData $checkbox 复选框句柄
     * @param string $text 文本
     * @return void
     */
    public static function setText(CData $checkbox, string $text): void
    {
        self::ffi()->uiCheckboxSetText($checkbox, $text);
    }

    /**
     * 复选框切换事件
     *
     * @param CData $checkbox 复选框句柄
     * @param callable $callback 回调函数
     * @return void
     */
    public static function onToggled(CData $checkbox, callable $callback): void
    {
        self::ffi()->uiCheckboxOnToggled($checkbox, function ($c, $d) use ($callback, $checkbox) {
            $callback($checkbox);
        }, null);
    }

    /**
     * 获取复选框是否选中
     *
     * @param CData $checkbox 复选框句柄
     * @return bool
     */
    public static function checked(CData $checkbox): bool
    {
        return self::ffi()->uiCheckboxChecked($checkbox);
    }

    /**
     * 设置复选框是否选中
     *
     * @param CData $checkbox 复选框句柄
     * @param bool $checked 是否选中
     * @return void
     */
    public static function setChecked(CData $checkbox, bool $checked): void
    {
        self::ffi()->uiCheckboxSetChecked($checkbox, $checked ? 1 : 0);
    }

    /**
     * 创建复选框
     *
     * @param string $text 文本
     * @return CData
     */
    public static function create(string $text): CData
    {
        return self::ffi()->uiNewCheckbox($text);
    }
}
