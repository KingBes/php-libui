<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 区域
 */
class Area extends Base
{
    /**
     * 创建区域处理程序
     *
     * @return CData
     */
    public static function handler(): CData
    {
        return self::ffi()->new("uiAreaHandler");
    }

    /**
     * 设置大小
     *
     * @param CData $a 区域句柄
     * @param int $width 宽度
     * @param int $height 高度
     * @return void
     */
    public static function setSize(CData $a, int $width, int $height): void
    {
        self::ffi()->uiAreaSetSize($a, $width, $height);
    }

    /**
     * 队列重绘
     *
     * @param CData $a 区域句柄
     * @return void
     */
    public static function queueRedraw(CData $a): void
    {
        self::ffi()->uiAreaQueueRedrawAll($a);
    }

    /**
     * 滚动到
     *
     * @param CData $a 区域句柄
     * @param float $x 横坐标
     * @param float $y 纵坐标
     * @param float $width 宽度
     * @param float $height 高度
     * @return void
     */
    public static function scrollTo(CData $a, float $x, float $y, float $width, float $height): void
    {
        self::ffi()->uiAreaScrollTo($a, $x, $y, $width, $height);
    }

    /**
     * 开始用户窗口移动
     * 
     * 注意：这些操作只能在鼠标相关处理程序中进行调用
     * 注意：是否应该允许在滚动区域使用这些操作？
     * 注意：确定哪些鼠标事件应被接受；“按下”是目前唯一能确保正常工作的事件
     * 注意：调用此函数之后到下一次鼠标抬起期间，事件会发生什么变化？
     * 注意：是否需要释放捕获状态？
     *
     * @param CData $a 区域句柄
     * @return void
     */
    public static function beginUserWindowMove(CData $a): void
    {
        self::ffi()->uiAreaBeginUserWindowMove($a);
    }

    /**
     * 开始用户窗口调整大小
     *
     * @param CData $a 区域句柄
     * @param AreaResizeEdge $edge 调整大小边缘
     * @return void
     */
    public static function beginUserWindowResize(CData $a, AreaResizeEdge $edge): void
    {
        self::ffi()->uiAreaBeginUserWindowResize($a, $edge->value);
    }

    /**
     * 创建区域
     *
     * @param CData $ah 区域句柄
     * @return CData
     */
    public static function create(CData $ah): CData
    {
        return self::ffi()->uiAreaCreate($ah);
    }

    /**
     * 创建滚动区域
     *
     * @param CData $ah 区域句柄
     * @param integer $width 宽度
     * @param integer $height 高度
     * @return CData
     */
    public static function createScroll(CData $ah, int $width, int $height): CData
    {
        return self::ffi()->uiNewScrollingArea($ah, $width, $height);
    }
}
