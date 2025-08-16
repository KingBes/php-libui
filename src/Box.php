<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 盒子类
 */
class Box extends Base
{
    /**
     * 追加子元素
     *
     * @param CData $box 盒子句柄
     * @param CData $child 子元素句柄
     * @param bool $stretchy 是否可拉伸
     * @return void
     */
    public static function append(CData $box, CData $child, bool $stretchy): void
    {
        $uiChildPtr = self::ffi()->cast("uiControl*", $child);
        self::ffi()->uiBoxAppend($box, $uiChildPtr, $stretchy ? 1 : 0);
    }

    /**
     * 获取子元素数量
     *
     * @param CData $box 盒子句柄
     * @return int
     */
    public static function numChildren(CData $box): int
    {
        return self::ffi()->uiBoxNumChildren($box);
    }

    /**
     * 删除子元素
     *
     * @param CData $box 盒子句柄
     * @param int $index 子元素索引
     * @return void
     */
    public static function delete(CData $box, int $index): void
    {
        self::ffi()->uiBoxDelete($box, $index);
    }

    /**
     * 获取是否有内边距
     *
     * @param CData $box 盒子句柄
     * @return bool
     */
    public static function padded(CData $box): bool
    {
        return self::ffi()->uiBoxPadded($box);
    }

    /**
     * 设置是否有内边距
     *
     * @param CData $box 盒子句柄
     * @param bool $padded 是否有内边距
     * @return void
     */
    public static function setPadded(CData $box, bool $padded): void
    {
        self::ffi()->uiBoxSetPadded($box, $padded ? 1 : 0);
    }

    /**
     * 创建水平盒子
     *
     * @return CData
     */
    public static function newHorizontalBox(): CData
    {
        return self::ffi()->uiNewHorizontalBox();
    }

    /**
     * 创建垂直盒子
     *
     * @return CData
     */
    public static function newVerticalBox(): CData
    {
        return self::ffi()->uiNewVerticalBox();
    }
}
