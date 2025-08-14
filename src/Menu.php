<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 菜单
 */
class Menu extends Base
{
    /**
     * 追加菜单项
     *
     * @param CData $menu 菜单句柄
     * @param string $name 菜单项名称
     * @return CData 菜单项句柄
     */
    public static function appendItem(CData $menu, string $name): CData
    {
        return self::ffi()->uiMenuAppendItem($menu, $name);
    }

    /**
     * 追加复选菜单项
     *
     * @param CData $menu 菜单句柄
     * @param string $name 菜单项名称
     * @return CData 菜单项句柄
     */
    public static function appendCheckItem(CData $menu, string $name): CData
    {
        return self::ffi()->uiMenuAppendCheckItem($menu, $name);
    }

    /**
     * 追加退出菜单项
     *
     * @param CData $menu 菜单句柄
     * @return CData 菜单项句柄
     */
    public static function appendQuitItem(CData $menu): CData
    {
        return self::ffi()->uiMenuAppendQuitItem($menu);
    }

    /**
     * 追加首选项菜单项
     *
     * @param CData $menu 菜单句柄
     * @return CData 菜单项句柄
     */
    public static function appendPreferencesItem(CData $menu): CData
    {
        return self::ffi()->uiMenuAppendPreferencesItem($menu);
    }

    /**
     * 追加关于菜单项
     *
     * @param CData $menu 菜单句柄
     * @return CData 菜单项句柄
     */
    public static function appendAboutItem(CData $menu): CData
    {
        return self::ffi()->uiMenuAppendAboutItem($menu);
    }

    /**
     * 追加分隔线
     *
     * @param CData $menu 菜单句柄
     * @return void
     */
    public static function appendSeparator(CData $menu): void
    {
        self::ffi()->uiMenuAppendSeparator($menu);
    }

    /**
     * 创建菜单
     *
     * @param string $name 菜单名称
     * @return CData 菜单句柄
     */
    public static function create(string $name): CData
    {
        return self::ffi()->uiMenuNew($name);
    }
}
