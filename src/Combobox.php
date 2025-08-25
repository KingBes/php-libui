<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 下拉列表框
 */
class Combobox extends Base
{
    /**
     * 创建下拉列表框
     *
     * @return CData
     */
    public static function create(): CData
    {
        return self::ffi()->uiNewCombobox();
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
        self::ffi()->uiComboboxAppend($combobox, $text);
    }


    /**
     * 获取选中项索引
     *
     * @param CData $combobox 下拉列表框句柄
     * @return int 选中项索引
     */
    public static function selected(CData $combobox): int
    {
        return self::ffi()->uiComboboxSelected($combobox);
    }

    /**
     * 设置选中项索引
     *
     * @param CData $combobox 下拉列表框句柄
     * @param int $index 选中项索引
     * @return void
     */
    public static function setSelected(CData $combobox, int $index): void
    {
        self::ffi()->uiComboboxSetSelected($combobox, $index);
    }

    /**
     * 选中项改变事件
     *
     * @param CData $combobox 下拉列表框句柄
     * @param callable $callback 回调函数
     * @return void
     */
    public static function onSelected(CData $combobox, callable $callback): void
    {
        self::ffi()->uiComboboxOnSelected(
            $combobox,
            function ($c, $d) use ($callback, $combobox) {
                $callback($combobox);
            },
            null
        );
    }
}
