<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 多行文本框
 */
class MultilineEntry extends Base
{
    /**
     * 创建多行文本框
     *
     * @return CData
     */
    public static function create(): CData
    {
        return self::ffi()->uiNewMultilineEntry();
    }

    /**
     * 创建非换行多行文本框
     *
     * @return CData
     */
    public static function createNonWrapping(): CData
    {
        return self::ffi()->uiNewNonWrappingMultilineEntry();
    }

    /**
     * 获取文本
     *
     * @param CData $entry 多行文本框句柄
     * @return string 文本
     */
    public static function text(CData $entry): string
    {
        return self::ffi()->uiMultilineEntryText($entry);
    }

    /**
     * 设置文本
     *
     * @param CData $entry 多行文本框句柄
     * @param string $text 文本
     * @return void
     */
    public static function setText(CData $entry, string $text): void
    {
        self::ffi()->uiMultilineEntrySetText($entry, $text);
    }

    /**
     * 追加文本
     *
     * @param CData $entry 多行文本框句柄
     * @param string $text 文本
     * @return void
     */
    public static function append(CData $entry, string $text): void
    {
        self::ffi()->uiMultilineEntryAppend($entry, $text);
    }

    /**
     * 文本改变事件
     *
     * @param CData $entry 多行文本框句柄
     * @param callable $callback 回调函数
     * @return void
     */
    public static function onChanged(CData $entry, callable $callback): void
    {
        self::ffi()->uiMultilineEntryOnChanged(
            $entry,
            function ($e, $d) use ($callback, $entry) {
                $callback($entry);
            },
            null
        );
    }

    /**
     * 获取是否只读
     *
     * @param CData $entry 多行文本框句柄
     * @return boolean
     */
    public static function readOnly(CData $entry): bool
    {
        return self::ffi()->uiMultilineEntryReadOnly($entry);
    }

    /**
     * 设置是否只读
     *
     * @param CData $entry 多行文本框句柄
     * @param boolean $readonly 是否只读
     * @return void
     */
    public static function setReadOnly(CData $entry, bool $readonly): void
    {
        self::ffi()->uiMultilineEntrySetReadOnly($entry, $readonly ? 1 : 0);
    }
}
