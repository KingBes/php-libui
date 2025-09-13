<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 菜单项
 */
class MenuItem extends Base
{
    /**
     * 启用
     *
     * @param CData $item 菜单项句柄
     * @return void
     */
    public static function enable(CData $item): void
    {
        self::ffi()->uiMenuItemEnable($item);
    }

    /**
     * 禁用
     *
     * @param CData $item 菜单项句柄
     * @return void
     */
    public static function disable(CData $item): void
    {
        self::ffi()->uiMenuItemDisable($item);
    }

    /**
     * 点击事件
     *
     * @param CData $item 菜单项句柄
     * @param callable $callback 回调函数
     * @return void
     */
    public static function onClicked(CData $item, callable $callback): void
    {
        self::ffi()->uiMenuItemOnClicked(
            $item,
            function ($s, $w, $d) use ($callback, $item) {
                $callback($item, $w);
            },
            null
        );
    }

    /**
     * 获取是否选中
     *
     * @param CData $item 菜单项句柄
     * @return boolean
     */
    public static function checked(CData $item): bool
    {
        return self::ffi()->uiMenuItemChecked($item);
    }

    /**
     * 设置是否选中
     *
     * @param CData $item 菜单项句柄
     * @param boolean $checked 是否选中
     * @return void
     */
    public static function setChecked(CData $item, bool $checked): void
    {
        self::ffi()->uiMenuItemSetChecked($item, $checked ? 1 : 0);
    }
}
