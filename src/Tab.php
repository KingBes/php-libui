<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 标签页类
 */
class Tab extends Base
{
    /**
     * 追加标签页
     *
     * @param CData $tab 标签页句柄
     * @param string $name 标签页名称
     * @param CData $control 标签页内容
     * @return void
     */
    public static function append(CData $tab, string $name, CData $control): void
    {
        $uiControlPtr = self::ffi()->cast("uiControl*", $control);
        self::ffi()->uiTabAppend($tab, $name, $uiControlPtr);
    }

    /**
     * 插入标签页
     *
     * @param CData $tab 标签页句柄
     * @param string $name 标签页名称
     * @param int $before 插入位置
     * @param CData $control 标签页内容
     * @return void
     */
    public static function insertAt(CData $tab, string $name, int $before, CData $control): void
    {
        $uiControlPtr = self::ffi()->cast("uiControl*", $control);
        self::ffi()->uiTabInsertAt($tab, $name, $before, $uiControlPtr);
    }

    /**
     * 删除标签页
     *
     * @param CData $tab 标签页句柄
     * @param int $index 标签页索引
     * @return void
     */
    public static function delete(CData $tab, int $index): void
    {
        self::ffi()->uiTabDelete($tab, $index);
    }

    /**
     * 获取标签页数量
     *
     * @param CData $tab 标签页句柄
     * @return int
     */
    public static function numPages(CData $tab): int
    {
        return self::ffi()->uiTabNumPages($tab);
    }

    /**
     * 设置是否显示标签
     *
     * @param CData $tab 标签页句柄
     * @param bool $margined 是否显示标签
     * @return int
     */
    public static function margined(CData $tab, bool $margined): int
    {
        return self::ffi()->uiTabMargined($tab, $margined);
    }

    /**
     * 设置标签页是否显示标签
     *
     * @param CData $tab 标签页句柄
     * @param integer $page 标签页索引
     * @param boolean $margined 是否显示标签
     * @return void
     */
    public static function setMargined(CData $tab, int $page, bool $margined): void
    {
        self::ffi()->uiTabSetMargined($tab, $page, $margined);
    }

    /**
     * 创建标签页
     *
     * @return CData
     */
    public static function create(): CData
    {
        return self::ffi()->uiNewTab();
    }
}
