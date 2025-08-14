<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 单选框
 */
class Radio extends Base
{
    /**
     * 创建单选框
     *
     * @return CData
     */
    public static function create(): CData
    {
        return self::ffi()->uiNewRadioButtons();
    }

    /**
     * 添加选项
     *
     * @param CData $radio 单选框句柄
     * @param string $text 选项文本
     * @return void
     */
    public static function append(CData $radio, string $text): void
    {
        self::ffi()->uiRadioButtonsAppend($radio, $text);
    }

    /**
     * 获取选中项索引
     *
     * @param CData $radio 单选框句柄
     * @return int 选中项索引
     */
    public static function selected(CData $radio): int
    {
        return self::ffi()->uiRadioButtonsSelected($radio);
    }

    /**
     * 设置选中项索引
     *
     * @param CData $radio 单选框句柄
     * @param int $index 选中项索引
     * @return void
     */
    public static function setSelected(CData $radio, int $index): void
    {
        self::ffi()->uiRadioButtonsSetSelected($radio, $index);
    }

    /**
     * 选中项改变事件
     *
     * @param CData $radio 单选框句柄
     * @param callable $callback 回调函数
     * @return void
     */
    public static function onSelected(CData $radio, callable $callback): void
    {
        self::ffi()->uiRadioButtonsOnSelected(
            $radio,
            function ($r, $d) use ($callback, $radio) {
                $callback($radio);
            },
            null
        );
    }
}
