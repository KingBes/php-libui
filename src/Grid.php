<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 网格布局类
 */
class Grid extends Base
{
    /**
     * 创建网格布局
     *
     * @return CData
     */
    public static function create(): CData
    {
        return self::ffi()->uiNewGrid();
    }

    /**
     * 追加控件
     *
     * @param CData $g 网格布局句柄
     * @param CData $c 控件句柄
     * @param integer $left 控件左坐标
     * @param integer $top 控件上坐标
     * @param integer $xspan 控件水平跨度
     * @param integer $yspan 控件垂直跨度
     * @param integer $hexpand 控件水平是否展开
     * @param integer $halign 控件水平对齐
     * @param integer $vexpand 控件垂直是否展开
     * @param Align $valign 控件垂直对齐
     * @return void
     */
    public static function append(CData $g, CData $c, int $left, int $top, int $xspan, int $yspan, int $hexpand, int $halign, int $vexpand, Align $valign)
    {
        $control = self::ffi()->cast("uiControl *", $c);
        self::ffi()->uiGridAppend($g, $control, $left, $top, $xspan, $yspan, $hexpand, $halign, $vexpand, $valign->value);
    }

    /**
     * 插入控件
     *
     * @param CData $g 网格布局句柄
     * @param CData $c 控件句柄
     * @param CData $existing 已存在控件句柄
     * @param At $at 插入位置
     * @param integer $xspan 控件水平跨度
     * @param integer $yspan 控件垂直跨度
     * @param integer $hexpand 控件水平是否展开
     * @param Align $halign 控件水平对齐
     * @param integer $vexpand 控件垂直是否展开
     * @param Align $valign 控件垂直对齐
     * @return void
     */
    public static function insertAt(CData $g, CData $c, CData $existing, At $at, int $xspan, int $yspan, int $hexpand, Align $halign, int $vexpand, Align $valign)
    {
        self::ffi()->uiGridInsertAt($g, $c, $existing, $at->value, $xspan, $yspan, $hexpand, $halign->value, $vexpand, $valign->value);
    }

    /**
     * 获取网格布局是否有内边距
     *
     * @param CData $g 网格布局句柄
     * @return boolean 是否有内边距
     */
    public static function padded(CData $g): bool
    {
        return self::ffi()->uiGridPadded($g);
    }

    /**
     * 设置网格布局是否有内边距
     *
     * @param CData $g 网格布局句柄
     * @param boolean $padded 是否有内边距
     * @return void
     */
    public static function setPadded(CData $g, bool $padded): void
    {
        self::ffi()->uiGridSetPadded($g, $padded ? 1 : 0);
    }
}
