<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 绘制
 */
class Draw extends Base
{
    /**
     * 新建路径
     *
     * @param DrawFillMode $fillMode 填充模式
     * @return CData 路径句柄
     */
    public static function createPath(DrawFillMode $fillMode): CData
    {
        return self::ffi()->uiDrawNewPath($fillMode->value);
    }

    /**
     * 释放路径(一般php不需要)
     *
     * @param CData $path 路径句柄
     * @return void
     */
    public static function freePath(CData $path): void
    {
        self::ffi()->uiDrawFreePath($path);
    }

    /**
     * 创建路径图
     *
     * @param CData $path 路径句柄
     * @param float $x 图起点x坐标
     * @param float $y 图起点y坐标
     * @return void
     */
    public static function createPathFigure(CData $path, float $x, float $y): void
    {
        self::ffi()->uiDrawPathNewFigure($path, $x, $y);
    }

    /**
     * 创建路径图(圆弧)
     *
     * @param CData $path 路径句柄
     * @param float $xCenter 圆弧中心x坐标
     * @param float $yCenter 圆弧中心y坐标
     * @param float $radius 圆弧半径
     * @param float $startAngle 圆弧起始角度
     * @param float $sweep 圆弧扫掠角度
     * @param bool $negative false:顺时针,true:逆时针
     * @return void
     */
    public static function createPathFigureWithArc(
        CData $path,
        float $xCenter,
        float $yCenter,
        float $radius,
        float $startAngle,
        float $sweep,
        bool $negative = false
    ): void {
        self::ffi()->uiDrawPathNewFigureWithArc(
            $path,
            $xCenter,
            $yCenter,
            $radius,
            $startAngle,
            $sweep,
            $negative ? 1 : 0
        );
    }

    /**
     * 路径添加直线
     *
     * @param CData $path 路径句柄
     * @param float $x 直线终点x坐标
     * @param float $y 直线终点y坐标
     * @return void
     */
    public static function pathLineTo(CData $path, float $x, float $y): void
    {
        self::ffi()->uiDrawPathLineTo($path, $x, $y);
    }

    /**
     * 路径添加圆弧
     *
     * @param CData $path 路径句柄
     * @param float $xCenter 圆弧中心x坐标
     * @param float $yCenter 圆弧中心y坐标
     * @param float $radius 圆弧半径
     * @param float $startAngle 圆弧起始角度
     * @param float $sweep 圆弧扫掠角度
     * @param bool $negative false:顺时针,true:逆时针
     * @return void
     */
    public static function pathArcTo(
        CData $path,
        float $xCenter,
        float $yCenter,
        float $radius,
        float $startAngle,
        float $sweep,
        bool $negative = false
    ): void {
        self::ffi()->uiDrawPathArcTo(
            $path,
            $xCenter,
            $yCenter,
            $radius,
            $startAngle,
            $sweep,
            $negative ? 1 : 0
        );
    }

    /**
     * 路径添加贝塞尔曲线
     *
     * @param CData $path 路径句柄
     * @param float $c1x 控制点1x坐标
     * @param float $c1y 控制点1y坐标
     * @param float $c2x 控制点2x坐标
     * @param float $c2y 控制点2y坐标
     * @param float $endX 终点x坐标
     * @param float $endY 终点y坐标
     * @return void
     */
    public static function pathBezierTo(
        CData $path,
        float $c1x,
        float $c1y,
        float $c2x,
        float $c2y,
        float $endX,
        float $endY
    ): void {
        self::ffi()->uiDrawPathBezierTo($path, $c1x, $c1y, $c2x, $c2y, $endX, $endY);
    }

    /**
     * 路径关闭
     *
     * @param CData $path 路径句柄
     * @return void
     */
    public static function pathCloseFigure(CData $path): void
    {
        self::ffi()->uiDrawPathCloseFigure($path);
    }

    /**
     * 路径添加矩形
     *
     * @param CData $path 路径句柄
     * @param float $x 矩形起点x坐标
     * @param float $y 矩形起点y坐标
     * @param float $width 矩形宽度
     * @param float $height 矩形高度
     * @return void
     */
    public static function pathAddRectangle(
        CData $path,
        float $x,
        float $y,
        float $width,
        float $height
    ): void {
        self::ffi()->uiDrawPathAddRectangle($path, $x, $y, $width, $height);
    }

    /**
     * 路径结束
     *
     * @param CData $path 路径句柄
     * @return void
     */
    public static function pathEnd(CData $path): void
    {
        self::ffi()->uiDrawPathEnd($path);
    }

    /**
     * 绘制路径
     *
     * @param CData $c 上下文句柄
     * @param CData $path 路径句柄
     * @param CData $brush 画笔句柄
     * @param CData $params 绘制参数句柄
     * @return void
     */
    public static function Stroke(CData $c, CData $path, CData $brush, CData $params): void
    {
        self::ffi()->uiDrawStroke($c, $path, $brush, $params);
    }

    /**
     * 填充路径
     *
     * @param CData $c 上下文句柄
     * @param CData $path 路径句柄
     * @param CData $brush 画笔句柄
     * @return void
     */
    public static function fill(CData $c, CData $path, CData $brush): void
    {
        self::ffi()->uiDrawFill($c, $path, $brush);
    }

    /**
     * 矩阵设置为单位矩阵
     *
     * @param CData $m 矩阵句柄
     * @return void
     */
    public static function matrixSetIdentity(CData $m): void
    {
        self::ffi()->uiDrawMatrixSetIdentity($m);
    }

    /**
     * 矩阵平移
     *
     * @param CData $m 矩阵句柄
     * @param float $x 平移x坐标
     * @param float $y 平移y坐标
     * @return void
     */
    public static function matrixTranslate(CData $m, float $x, float $y): void
    {
        self::ffi()->uiDrawMatrixTranslate($m, $x, $y);
    }

    /**
     * 矩阵缩放
     *
     * @param CData $m 矩阵句柄
     * @param float $xCenter 缩放中心x坐标
     * @param float $yCenter 缩放中心y坐标
     * @param float $x 缩放x因子
     * @param float $y 缩放y因子
     * @return void
     */
    public static function matrixScale(CData $m, float $xCenter, float $yCenter, float $x, float $y): void
    {
        self::ffi()->uiDrawMatrixScale($m, $xCenter, $yCenter, $x, $y);
    }

    /**
     * 矩阵旋转
     *
     * @param CData $m 矩阵句柄
     * @param float $x 旋转中心x坐标
     * @param float $y 旋转中心y坐标
     * @param float $amount 旋转角度
     * @return void
     */
    public static function matrixRotate(CData $m, float $x, float $y, float $amount): void
    {
        self::ffi()->uiDrawMatrixRotate($m, $x, $y, $amount);
    }

    /**
     * 矩阵倾斜
     *
     * @param CData $m 矩阵句柄
     * @param float $x 倾斜中心x坐标
     * @param float $y 倾斜中心y坐标
     * @param float $xAmount 倾斜角度
     * @param float $yAmount 倾斜角度
     * @return void
     */
    public static function matrixSkew(CData $m, float $x, float $y, float $xAmount, float $yAmount): void
    {
        self::ffi()->uiDrawMatrixSkew($m, $x, $y, $xAmount, $yAmount);
    }

    /**
     * 矩阵乘法
     *
     * @param CData $m 矩阵句柄
     * @param CData $other 另一个矩阵句柄
     * @return void
     */
    public static function matrixMultiply(CData $m, CData $other): void
    {
        self::ffi()->uiDrawMatrixMultiply($m, $other);
    }

    /**
     * 矩阵是否可逆
     *
     * @param CData $m 矩阵句柄
     * @return bool
     */
    public static function matrixInvertible(CData $m): bool
    {
        return self::ffi()->uiDrawMatrixInvertible($m);
    }

    /**
     * 矩阵求逆
     *
     * @param CData $m 矩阵句柄
     * @return bool
     */
    public static function matrixInvert(CData $m): bool
    {
        return self::ffi()->uiDrawMatrixInvert($m);
    }

    /**
     * 矩阵变换点
     *
     * @param CData $m 矩阵句柄
     * @param array<float> $xArr 点x坐标数组
     * @param array<float> $yArr 点y坐标数组
     * @return void
     */
    public static function matrixTransformPoint(CData $m, array $xArr, array $yArr): void
    {
        $c_xArr = self::ffi()->new("double[{count($xArr)}]");
        $c_yArr = self::ffi()->new("double[{count($yArr)}]");
        for ($i = 0; $i < count($xArr); $i++) {
            $c_xArr[$i] = $xArr[$i];
            $c_yArr[$i] = $yArr[$i];
        }
        self::ffi()->uiDrawMatrixTransformPoint($m, $c_xArr, $c_yArr);
    }

    /**
     * 矩阵变换大小
     *
     * @param CData $m 矩阵句柄
     * @param array<float> $widthArr 宽度数组
     * @param array<float> $heightArr 高度数组
     * @return void
     */
    public static function matrixTransformSize(CData $m, array $widthArr, array $heightArr): void
    {
        $c_widthArr = self::ffi()->new("double[{count($widthArr)}]");
        $c_heightArr = self::ffi()->new("double[{count($heightArr)}]");
        for ($i = 0; $i < count($widthArr); $i++) {
            $c_widthArr[$i] = $widthArr[$i];
            $c_heightArr[$i] = $heightArr[$i];
        }
        self::ffi()->uiDrawMatrixTransformSize($m, $c_widthArr, $c_heightArr);
    }

    /**
     * 变换上下文
     *
     * @param CData $c 上下文句柄
     * @param CData $m 矩阵句柄
     * @return void
     */
    public static function transform(CData $c, CData $m): void
    {
        self::ffi()->uiDrawTransform($c, $m);
    }

    /**
     * 剪辑上下文
     *
     * @param CData $c 上下文句柄
     * @param CData $path 路径句柄
     * @return void
     */
    public static function clip(CData $c, CData $path): void
    {
        self::ffi()->uiDrawClip($c, $path);
    }

    /**
     * 保存上下文
     *
     * @param CData $c 上下文句柄
     * @return void
     */
    public static function save(CData $c): void
    {
        self::ffi()->uiDrawSave($c);
    }

    /**
     * 恢复上下文
     *
     * @param CData $c 上下文句柄
     * @return void
     */
    public static function restore(CData $c): void
    {
        self::ffi()->uiDrawRestore($c);
    }

    /**
     * 创建文本布局
     *
     * @param CData $params 文本布局参数句柄
     * @return CData 文本布局句柄
     */
    public static function createTextLayout(CData $params): CData
    {
        return self::ffi()->uiDrawNewTextLayout($params);
    }

    /**
     * 释放文本布局
     *
     * @param CData $tl 文本布局句柄
     * @return void
     */
    public static function freeTextLayout(CData $tl): void
    {
        self::ffi()->uiDrawFreeTextLayout($tl);
    }

    /**
     * 绘制文本
     *
     * @param CData $c 上下文句柄
     * @param CData $tl 文本布局句柄
     * @param float $x 文本x坐标
     * @param float $y 文本y坐标
     * @return void
     */
    public static function text(CData $c, CData $tl, float $x, float $y): void
    {
        self::ffi()->uiDrawText($c, $tl, $x, $y);
    }

    /**
     * 获取文本布局尺寸
     *
     * @param CData $tl 文本布局句柄
     * @param float $width 文本宽度
     * @param float $height 文本高度
     * @return void
     */
    public static function textLayoutExtents(CData $tl, float $width, float $height): void
    {
        self::ffi()->uiDrawTextLayoutExtents($tl, $width, $height);
    }
}
