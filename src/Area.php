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
     * 区域处理程序用于处理区域的绘制、键盘事件、鼠标事件、鼠标跨域事件和拖动中断事件。
     * 
     * @param callable<$handler> $draw 绘制回调函数
     * @param callable<$handler, CData, CData>|null $KeyEvent 键盘事件回调函数
     * @param callable<$handler, CData, CData>|null $MouseEvent 鼠标事件回调函数
     * @param callable<$handler, CData, int>|null $MouseCrossed 鼠标跨域事件回调函数
     * @param callable<$handler, CData>|null $DragBroken 拖动中断事件回调函数
     *
     * @return CData
     */
    public static function handler(
        callable $draw,
        callable|null $KeyEvent = null,
        callable|null $MouseEvent = null,
        callable|null $MouseCrossed = null,
        callable|null $DragBroken = null,
    ): CData {
        $uiAreaHandler = self::ffi()->new("uiAreaHandler [1]");
        $c_draw = function ($uiAreaHandler, $area, $params) use ($draw) {
            $draw($uiAreaHandler);
        };
        $uiAreaHandler[0]->Draw = $c_draw;

        if ($KeyEvent) {
            $c_KeyEvent = function ($uiAreaHandler  , $area, $keyEvent) use ($KeyEvent) {
                return $KeyEvent($uiAreaHandler , $area, $keyEvent);
            };
            $uiAreaHandler[0]->KeyEvent = $c_KeyEvent;
        }

        if ($MouseEvent) {
            $c_MouseEvent = function ($uiAreaHandler, $area, $mouseEvent) use ($MouseEvent) {
                $MouseEvent($uiAreaHandler, $area, $mouseEvent);
            };
            $uiAreaHandler[0]->MouseEvent = $c_MouseEvent;
        }
        if ($MouseCrossed) {
            $c_MouseCrossed = function ($uiAreaHandler, $area, $left) use ($MouseCrossed) {
                $MouseCrossed($uiAreaHandler, $area, $left);
            };
            $uiAreaHandler[0]->MouseCrossed = $c_MouseCrossed;
        }
        if ($DragBroken) {
            $c_DragBroken = function ($uiAreaHandler, $area) use ($DragBroken) {
                $DragBroken($uiAreaHandler, $area);
            };
            $uiAreaHandler[0]->DragBroken = $c_DragBroken;
        }
        return $uiAreaHandler;
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
        return self::ffi()->uiNewArea($ah);
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
        $c_ah = self::ffi()->cast("uiAreaHandler *", $ah);
        return self::ffi()->uiNewScrollingArea($c_ah, $width, $height);
    }

    /**
     * 创建区域绘画参数
     *
     * @param float $AreaWidth 区域宽度
     * @param float $AreaHeight 区域高度
     * @param float $ClipX 裁剪区域左坐标
     * @param float $ClipY 裁剪区域上坐标
     * @param float $ClipWidth 裁剪区域宽度
     * @param float $ClipHeight 裁剪区域高度
     * @return CData
     */
    public static function createDrawParams(
        float $AreaWidth = 0.0,
        float $AreaHeight = 0.0,
        float $ClipX = 0.0,
        float $ClipY = 0.0,
        float $ClipWidth = 0.0,
        float $ClipHeight = 0.0
    ): CData {
        $drawParams = self::ffi()->new("uiAreaDrawParams");
        $drawParams->AreaWidth = $AreaWidth;
        $drawParams->AreaHeight = $AreaHeight;
        $drawParams->ClipX = $ClipX;
        $drawParams->ClipY = $ClipY;
        $drawParams->ClipWidth = $ClipWidth;
        $drawParams->ClipHeight = $ClipHeight;
        return $drawParams;
    }
}
