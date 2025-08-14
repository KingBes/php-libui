<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 标签类
 */
class Label extends Base
{
    /**
     * 获取标签文本
     *
     * @param CData $label 标签句柄
     * @return string
     */
    public static function text(CData $label): string
    {
        return self::ffi()->uiLabelText($label);
    }

    /**
     * 设置标签文本
     *
     * @param CData $label 标签句柄
     * @param string $text 文本
     * @return void
     */
    public static function setText(CData $label, string $text): void
    {
        self::ffi()->uiLabelSetText($label, $text);
    }

    /**
     * 创建标签
     *
     * @param string $text 文本
     * @return CData
     */
    public static function create(string $text): CData
    {
        return self::ffi()->uiNewLabel($text);
    }
}
