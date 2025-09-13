<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 组类
 */
class Group extends Base
{
    /**
     * 获取组标题
     *
     * @param CData $group 组句柄
     * @return string
     */
    public static function title(CData $group): string
    {
        return self::ffi()->uiGroupTitle($group);
    }

    /**
     * 设置组标题
     *
     * @param CData $group 组句柄
     * @param string $title 标题
     * @return void
     */
    public static function setTitle(CData $group, string $title): void
    {
        self::ffi()->uiGroupSetTitle($group, $title);
    }

    /**
     * 设置组子控件
     *
     * @param CData $group 组句柄
     * @param CData $child 子控件句柄
     * @return void
     */
    public static function setChild(CData $group, CData $child): void
    {
        $uiControlPtr = self::ffi()->cast("uiControl*", $child);
        self::ffi()->uiGroupSetChild($group, $uiControlPtr);
    }

    /**
     * 获取组是否有边距
     *
     * @param CData $group 组句柄
     * @return bool 是否有边距
     */
    public static function margined(CData $group): bool
    {
        return self::ffi()->uiGroupMargined($group);
    }

    /**
     * 设置组是否有边距
     *
     * @param CData $group 组句柄
     * @param bool $margined 是否有边距
     * @return void
     */
    public static function setMargined(CData $group, bool $margined): void
    {
        self::ffi()->uiGroupSetMargined($group, $margined ? 1 : 0);
    }

    /**
     * 创建组
     *
     * @param string $title 组标题
     * @return CData 组句柄
     */
    public static function create(string $title): CData
    {
        return self::ffi()->uiNewGroup($title);
    }
}
