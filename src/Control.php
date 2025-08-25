<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 控件基类
 */
class Control extends Base
{
    /**
     * 销毁控件
     *
     * @param CData $control 控件句柄
     * @return void
     */
    public static function destroy(CData $control): void
    {
        $uiControlPtr = self::ffi()->cast("uiControl*", $control);
        self::ffi()->uiControlDestroy($uiControlPtr);
    }

    /**
     * 获取控件句柄
     *
     * @param CData $control 控件句柄
     * @return CData 控件句柄
     */
    public static function handle(CData $control): CData
    {
        $uiControlPtr = self::ffi()->cast("uiControl*", $control);
        return self::ffi()->uiControlHandle($uiControlPtr);
    }

    /**
     * 获取控件父容器
     *
     * @param CData $control 控件句柄
     * @return CData 父容器句柄
     */
    public static function parent(CData $control): CData
    {
        $uiControlPtr = self::ffi()->cast("uiControl*", $control);
        return self::ffi()->uiControlParent($uiControlPtr);
    }

    /**
     * 设置控件父容器
     *
     * @param CData $control 控件句柄
     * @param CData $parent 父容器句柄
     * @return void
     */
    public static function setParent(CData $control, CData $parent): void
    {
        $uiControlPtr = self::ffi()->cast("uiControl*", $control);
        $uiParentPtr = self::ffi()->cast("uiControl*", $parent);
        self::ffi()->uiControlSetParent($uiControlPtr, $uiParentPtr);
    }

    /**
     * 控件等级
     *
     * @param CData $control 控件句柄
     * @return integer 控件等级
     */
    public static function topLevel(CData $control): int
    {
        $uiControlPtr = self::ffi()->cast("uiControl*", $control);
        return self::ffi()->uiControlTopLevel($uiControlPtr);
    }

    /**
     * 控件是否可见
     *
     * @param CData $control 控件句柄
     * @return bool 是否可见
     */
    public static function visible(CData $control): bool
    {
        $uiControlPtr = self::ffi()->cast("uiControl*", $control);
        return self::ffi()->uiControlVisible($uiControlPtr);
    }

    /**
     * 显示控件
     *
     * @param CData $control 控件句柄
     * @return void
     */
    public static function show(CData $control): void
    {
        $uiControlPtr = self::ffi()->cast("uiControl*", $control);
        self::ffi()->uiControlShow($uiControlPtr);
    }

    /**
     * 隐藏控件
     *
     * @param CData $control 控件句柄
     * @return void
     */
    public static function hide(CData $control): void
    {
        $uiControlPtr = self::ffi()->cast("uiControl*", $control);
        self::ffi()->uiControlHide($uiControlPtr);
    }

    /**
     * 控件是否启用
     *
     * @param CData $control 控件句柄
     * @return bool 是否启用
     */
    public static function enabled(CData $control): bool
    {
        $uiControlPtr = self::ffi()->cast("uiControl*", $control);
        return self::ffi()->uiControlEnabled($uiControlPtr);
    }

    /**
     * 启用控件
     *
     * @param CData $control 控件句柄
     * @return void
     */
    public static function enable(CData $control): void
    {
        $uiControlPtr = self::ffi()->cast("uiControl*", $control);
        self::ffi()->uiControlEnable($uiControlPtr);
    }

    /**
     * 禁用控件
     *
     * @param CData $control 控件句柄
     * @return void
     */
    public static function disable(CData $control): void
    {
        $uiControlPtr = self::ffi()->cast("uiControl*", $control);
        self::ffi()->uiControlDisable($uiControlPtr);
    }

    /**
     * 分配控件
     *
     * @param integer $n 控件类型
     * @param integer $OSsig 操作系统类型
     * @param integer $typesig 控件类型
     * @param string $typenamestr 控件类型字符串
     * @return CData
     */
    public static function allocControl(int $n, int $OSsig, int $typesig, string $typenamestr): CData
    {
        return self::ffi()->uiAllocControl($n, $OSsig, $typesig, $typenamestr);
    }

    /**
     * 释放控件(一般PHP不需要)
     *
     * @param CData $control 控件句柄
     * @return void
     */
    public static function free(CData $control): void
    {
        self::ffi()->uiFreeControl($control);
    }

    /**
     * 验证并设置控件父容器
     *
     * @param CData $control 控件句柄
     * @param CData $parent 父容器句柄
     * @return void
     */
    public static function verifySetParent(CData $control, CData $parent): void
    {
        $uiControlPtr = self::ffi()->cast("uiControl*", $control);
        $uiParentPtr = self::ffi()->cast("uiControl*", $parent);
        self::ffi()->uiVerifySetParent($uiControlPtr, $uiParentPtr);
    }

    /**
     * 控件是否对用户可见
     *
     * @param CData $control 控件句柄
     * @return bool 是否对用户可见
     */
    public static function enabledToUser(CData $control): bool
    {
        $uiControlPtr = self::ffi()->cast("uiControl*", $control);
        return self::ffi()->uiControlEnabledToUser($uiControlPtr);
    }

    /**
     * 控件类型不能设置为顶级容器
     *
     * @param string $type 控件类型
     * @return void
     */
    public static function userBugCannotSetParentOnToplevel(string $type): void
    {
        self::ffi()->uiUserBugCannotSetParentOnToplevel($type);
    }
}
