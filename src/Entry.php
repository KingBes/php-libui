<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 输入框类
 */
class Entry extends Base
{
    /**
     * 获取输入框文本
     *
     * @param CData $entry 输入框句柄
     * @return string
     */
    public static function text(CData $entry): string
    {
        return self::ffi()->uiEntryText($entry);
    }

    /**
     * 设置输入框文本
     *
     * @param CData $entry 输入框句柄
     * @param string $text 文本
     * @return void
     */
    public static function setText(CData $entry, string $text): void
    {
        self::ffi()->uiEntrySetText($entry, $text);
    }

    /**
     * 输入框文本改变事件
     *
     * @param CData $entry 输入框句柄
     * @param callable $callback 回调函数
     * @return void
     */
    public static function onChanged(CData $entry, callable $callback): void
    {
        self::ffi()->uiEntryOnChanged($entry, function ($e, $d) use ($callback, $entry) {
            $callback($entry);
        }, null);
    }

    /**
     * 获取是否只读
     *
     * @param CData $entry 输入框句柄
     * @return bool
     */
    public static function readOnly(CData $entry): bool
    {
        return self::ffi()->uiEntryReadOnly($entry);
    }

    /**
     * 设置是否只读
     *
     * @param CData $entry 输入框句柄
     * @param bool $readOnly 是否只读
     * @return void
     */
    public static function setReadOnly(CData $entry, bool $readOnly): void
    {
        self::ffi()->uiEntrySetReadOnly($entry, $readOnly ? 1 : 0);
    }

    /**
     * 创建输入框
     *
     * @return CData
     */
    public static function create(): CData
    {
        return self::ffi()->uiNewEntry();
    }

    /**
     * 创建密码输入框
     *
     * @return CData
     */
    public static function createPwd(): CData
    {
        return self::ffi()->uiNewPasswordEntry();
    }

    /**
     * 创建搜索输入框
     *
     * @return CData
     */
    public static function createSearch(): CData
    {
        return self::ffi()->uiNewSearchEntry();
    }
}
