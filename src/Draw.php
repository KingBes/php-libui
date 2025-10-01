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
        $c_uiDrawStrokeParams = self::ffi()::addr($params);
        self::ffi()->uiDrawStroke($c[0]->Context, $path, $brush, $c_uiDrawStrokeParams);
    }

    /**
     * 填充路径
     *
     * @param CData $params 区域绘画参数
     * @param CData $path 路径句柄
     * @param CData $brush 画笔句柄
     * @return void
     */
    public static function fill(CData $context, CData $path, CData $brush): void
    {
        self::ffi()->uiDrawFill($context[0]->Context, $path, $brush);
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
        self::ffi()->uiDrawClip($c[0]->Context, $path);
    }

    /**
     * 保存上下文
     *
     * @param CData $c 上下文句柄
     * @return void
     */
    public static function save(CData $c): void
    {
        self::ffi()->uiDrawSave($c[0]->Context);
    }

    /**
     * 恢复上下文
     *
     * @param CData $c 上下文句柄
     * @return void
     */
    public static function restore(CData $c): void
    {
        self::ffi()->uiDrawRestore($c[0]->Context);
    }

    /**
     * 创建文本布局
     *
     * @param CData $params 文本布局参数句柄
     * @return CData 文本布局句柄
     */
    public static function createTextLayout(CData $params): CData
    {
        $c_params = self::ffi()::addr($params);
        return self::ffi()->uiDrawNewTextLayout($c_params);
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
        self::ffi()->uiDrawText($c[0]->Context, $tl, $x, $y);
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

    /**
     * 创建矩阵
     *
     * @param float $m11 矩阵M11
     * @param float $m12 矩阵M12
     * @param float $m21 矩阵M21
     * @param float $m22 矩阵M22
     * @param float $M31 矩阵M31
     * @param float $M32 矩阵M32
     * @return CData 矩阵句柄
     */
    public static function createMatrix(float $m11, float $m12, float $m21, float $m22, float $M31, float $M32): CData
    {
        $uiDrawMatrix = self::ffi()->new("uiDrawMatrix");
        $uiDrawMatrix->M11 = $m11;
        $uiDrawMatrix->M12 = $m12;
        $uiDrawMatrix->M21 = $m21;
        $uiDrawMatrix->M22 = $m22;
        $uiDrawMatrix->M31 = $M31;
        $uiDrawMatrix->M32 = $M32;
        $c_uiDrawMatrix = self::ffi()->cast("uiDrawMatrix *", $uiDrawMatrix);
        return $c_uiDrawMatrix;
    }

    /**
     * 创建画笔渐变停止
     *
     * @param float $pos 位置 
     * @param float $r 红色通道值
     * @param float $g 绿色通道值
     * @param float $b 蓝色通道值
     * @param float $a 透明度通道值
     * @return CData 画笔渐变停止句柄
     */
    public static function createBrushGradientStop(float $pos, float $r, float $g, float $b, float $a): CData
    {
        $uiDrawBrushGradientStop = self::ffi()->new("uiDrawBrushGradientStop");
        $uiDrawBrushGradientStop->Pos = $pos;
        $uiDrawBrushGradientStop->R = $r;
        $uiDrawBrushGradientStop->G = $g;
        $uiDrawBrushGradientStop->B = $b;
        $uiDrawBrushGradientStop->A = $a;
        $c_uiDrawBrushGradientStop = self::ffi()->cast("uiDrawBrushGradientStop *", $uiDrawBrushGradientStop);
        return $c_uiDrawBrushGradientStop;
    }

    /**
     * 创建画笔
     *
     * @param DrawBrushType $type 画笔类型 0:Solid 1:Linear 2:Radial 3:image
     * @param float $r 红色通道值
     * @param float $g 绿色通道值
     * @param float $b 蓝色通道值
     * @param float $a 透明度通道值
     * @param float $x0 线性渐变开始X坐标，径向渐变开始X坐标
     * @param float $y0 线性渐变开始Y坐标，径向渐变开始Y坐标
     * @param float $x1 线性渐变结束X坐标，径向渐变外圆中心X坐标
     * @param float $y1 线性渐变结束Y坐标，径向渐变外圆中心Y坐标
     * @param float $outerRadius 径向渐变外圆半径
     * @param CData $Stops 画笔渐变停止句柄数组
     * @param integer $numStops 画笔渐变停止句柄数组长度
     * @return CData
     */
    public static function createBrush(
        DrawBrushType $type,
        float $r = 0.0,
        float $g = 0.0,
        float $b = 0.0,
        float $a = 1.0,
        float $x0 = 0.0,
        float $y0 = 0.0,
        float $x1 = 0.0,
        float $y1 = 0.0,
        float $outerRadius = 0.0
    ): CData {
        $uiDrawBrush = self::ffi()::addr(self::ffi()->new("struct uiDrawBrush"));
        $uiDrawBrushGradientStop = self::ffi()::addr(self::ffi()->new("struct uiDrawBrushGradientStop"));
        $uiDrawBrush[0]->Type = $type->value;
        $uiDrawBrush[0]->R = $r;
        $uiDrawBrush[0]->G = $g;
        $uiDrawBrush[0]->B = $b;
        $uiDrawBrush[0]->A = $a;
        $uiDrawBrush[0]->Stops = $uiDrawBrushGradientStop;
        $uiDrawBrush[0]->X0 = $x0;
        $uiDrawBrush[0]->Y0 = $y0;
        $uiDrawBrush[0]->X1 = $x1;
        $uiDrawBrush[0]->Y1 = $y1;
        $uiDrawBrush[0]->OuterRadius = $outerRadius;
        return $uiDrawBrush;
    }

    /**
     * 创建画笔描边参数
     *
     * @param DrawLineCap $cap 画笔描边结束线帽类型 0:flat 1:round 2:square
     * @param DrawLineJoin $join 画笔描边交点类型 0:miter 1:round 2:bevel
     * @param DrawLineJoin $join1 画笔描边交点类型1
     * @param float $thickness 画笔描边宽度
     * @param float $miterLimit 画笔描边交点类型为Miter时的最大斜接长度
     * @param integer $numDashes 画笔描边虚线数量
     * @param float $DashPhase 画笔描边虚线相位
     * @param float ...$Dashes 画笔描边虚线数组
     * @return CData
     */
    public static function createStrokeParams(DrawLineCap $cap, DrawLineJoin $join, DrawLineJoin $join1, float $thickness = 1.0, float $miterLimit = 0.0, int $numDashes = 0, float $DashPhase = 0.0, float ...$Dashes): CData
    {
        $uiDrawStrokeParams = self::ffi()->new("uiDrawStrokeParams");
        $uiDrawStrokeParams->Cap = $cap->value;
        $uiDrawStrokeParams->Join = $join->value;
        $uiDrawStrokeParams->Join1 = $join1->value;
        $uiDrawStrokeParams->Thickness = $thickness;
        $uiDrawStrokeParams->MiterLimit = $miterLimit;
        $uiDrawStrokeParams->DashPhase = $DashPhase;
        $uiDrawStrokeParams->NumDashes = $numDashes;
        if ($numDashes > 0) {
            $c_Dashes = self::ffi()->new("double[" . count($Dashes) . "]");
            for ($i = 0; $i < count($Dashes); $i++) {
                $c_Dashes[$i] = $Dashes[$i];
            }
            $uiDrawStrokeParams->Dashes = $c_Dashes;
        }
        return $uiDrawStrokeParams;
    }

    /**
     * 创建文本布局参数
     *
     * @param CData $str 文本字符串
     * @param CData $defaultFont 默认字体
     * @param float $width 文本宽度
     * @param TextAlign $align 文本对齐方式
     * @return CData 文本布局参数句柄
     */
    public static function createTextLayoutParams(CData $str, CData $defaultFont, float $width, TextAlign $align): CData
    {
        $uiDrawTextLayoutParams = self::ffi()->new("uiDrawTextLayoutParams");
        $uiDrawTextLayoutParams->String = $str;
        $uiDrawTextLayoutParams->DefaultFont = self::ffi()->cast("uiFontDescriptor *", $defaultFont);
        $uiDrawTextLayoutParams->Width = $width;
        $uiDrawTextLayoutParams->Align = $align->value;
        return $uiDrawTextLayoutParams;
    }

    /**
     * 创建字体描述符
     *
     * @param string $family 字体名称
     * @param float $size 字体大小
     * @param TextWeight $weight 字体重量
     * @param TextItalic $italic 字体斜体
     * @param TextStretch $stretch 字体拉伸
     * @return CData 字体描述符句柄
     */
    public static function createFontDesc(string $family, float $size, TextWeight $weight, TextItalic $italic, TextStretch $stretch): CData
    {
        $uiFontDescriptor = self::ffi()->new("uiFontDescriptor[1]");
        $char = self::ffi()->new("char[" . strlen($family) + 1 . "]");
        self::ffi()::memcpy($char, $family, strlen($family));
        $uiFontDescriptor[0]->Family = self::ffi()->cast("char *", $char);
        $uiFontDescriptor[0]->Size = $size;
        $uiFontDescriptor[0]->Weight = $weight->value;
        $uiFontDescriptor[0]->Italic = $italic->value;
        $uiFontDescriptor[0]->Stretch = $stretch->value;
        return $uiFontDescriptor;
    }
}
