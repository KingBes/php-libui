<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 可编辑下拉列表框
 */
class EditableCombobox extends Base
{
    /**
     * 创建可编辑下拉列表框
     *
     * @return CData
     */
    public static function create(): CData
    {
        return self::ffi()->uiNewEditableCombobox();
    }

    /**
     * 添加选项
     *
     * @param CData $combobox 下拉列表框句柄
     * @param string $text 选项文本
     * @return void
     */
    public static function append(CData $combobox, string $text): void
    {
        self::ffi()->uiEditableComboboxAppend($combobox, $text);
    }

    /**
     * 获取文本
     *
     * @param CData $combobox 下拉列表框句柄
     * @return string 文本
     */
    public static function text(CData $combobox): string
    {
        return self::ffi()->uiEditableComboboxText($combobox);
    }

    /**
     * 设置文本
     *
     * @param CData $combobox 下拉列表框句柄
     * @param string $text 文本
     * @return void
     */
    public static function setText(CData $combobox, string $text): void
    {
        self::ffi()->uiEditableComboboxSetText($combobox, $text);
    }

    /**
     * 文本改变事件
     *
     * @param CData $combobox 下拉列表框句柄
     * @param callable $callback 回调函数
     * @return void
     */
    public static function onChanged(CData $combobox, callable $callback): void
    {
        self::ffi()->uiEditableComboboxOnChanged(
            $combobox,
            function ($c, $d) use ($callback, $combobox) {
                $callback($combobox);
            },
            null
        );
    }
}
