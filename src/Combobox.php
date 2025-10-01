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
     * 在指定索引位置添加选项
     *
     * @param CData $combobox 下拉列表框句柄
     * @param int $index 索引位置
     * @param string $text 选项文本
     * @return void
     */
    public static function insertAt(CData $combobox, int $index, string $text): void
    {
        self::ffi()->uiComboboxInsertAt($combobox, $index, $text);
    }

    /**
     * 删除指定索引位置的选项
     *
     * @param CData $combobox 下拉列表框句柄
     * @param int $index 索引位置
     * @return void
     */
    public static function delete(CData $combobox, int $index): void
    {
        self::ffi()->uiComboboxDelete($combobox, $index);
    }

    /**
     * 清空所有选项
     *
     * @param CData $combobox 下拉列表框句柄
     * @return void
     */
    public static function clear(CData $combobox): void
    {
        self::ffi()->uiComboboxClear($combobox);
    }

    /**
     * 获取选项数量
     *
     * @param CData $combobox 下拉列表框句柄
     * @return int 选项数量
     */
    public static function numItems(CData $combobox): int
    {
        return self::ffi()->uiComboboxNumItems($combobox);
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
