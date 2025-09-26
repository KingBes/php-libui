<?php

namespace Kingbes\Libui;

use FFI\CData;

/**
 * 属性
 */
class Attribute extends Base
{
    /**
     * 释放属性
     *
     * @param CData $attr 属性句柄
     * @return void
     */
    public static function free(CData $attr): void
    {
        self::ffi()->uiFreeAttribute($attr);
    }

    /**
     * 获取属性类型
     *
     * @param CData $attr 属性句柄
     * @return AttributeType 属性类型
     */
    public static function getType(CData $attr): AttributeType
    {
        $type = self::ffi()->uiAttributeGetType($attr);
        return AttributeType::from($type);
    }

    /**
     * 创建属性族
     *
     * @param string $name 属性族名称
     * @return CData 属性族句柄
     */
    public static function createFamily(string $name): CData
    {
        $char = self::ffi()->new("char[" . strlen($name) + 1 . "]");
        self::ffi()::memcpy($char, $name, strlen($name));
        return self::ffi()->uiNewFamilyAttribute($char);
    }

    /**
     * 获取属性族
     *
     * @param CData $family 属性族句柄
     * @return string 属性族名称
     */
    public static function family(CData $family): string
    {
        return self::ffi()->uiAttributeFamily($family);
    }

    /**
     * 创建大小属性
     *
     * @param float $size 大小
     * @return CData 属性句柄
     */
    public static function createSize(float $size): CData
    {
        return self::ffi()->uiNewSizeAttribute($size);
    }

    /**
     * 获取大小属性值
     *
     * @param CData $attr 属性句柄
     * @return float 大小
     */
    public static function size(CData $attr): float
    {
        return self::ffi()->uiAttributeSize($attr);
    }

    /**
     * 创建权重属性
     *
     * @param TextWeight $weight 权重
     * @return CData 属性句柄
     */
    public static function createWeight(TextWeight $weight): CData
    {
        return self::ffi()->uiNewWeightAttribute($weight->value);
    }

    /**
     * 获取权重属性值
     *
     * @param CData $attr 属性句柄
     * @return TextWeight 权重
     */
    public static function weight(CData $attr): TextWeight
    {
        return TextWeight::from(self::ffi()->uiAttributeWeight($attr));
    }

    /**
     * 创建斜体属性
     *
     * @param TextItalic $italic 斜体
     * @return CData 属性句柄
     */
    public static function createItalic(TextItalic $italic): CData
    {
        return self::ffi()->uiNewItalicAttribute($italic->value);
    }

    /**
     * 获取斜体属性值
     *
     * @param CData $attr 属性句柄
     * @return TextItalic 斜体
     */
    public static function italic(CData $attr): TextItalic
    {
        return TextItalic::from(self::ffi()->uiAttributeItalic($attr));
    }

    /**
     * 创建拉伸属性
     *
     * @param TextStretch $stretch 拉伸
     * @return CData 属性句柄
     */
    public static function createStretch(TextStretch $stretch): CData
    {
        return self::ffi()->uiNewStretchAttribute($stretch->value);
    }

    /**
     * 获取拉伸属性值
     *
     * @param CData $attr 属性句柄
     * @return TextStretch 拉伸
     */
    public static function stretch(CData $attr): TextStretch
    {
        return TextStretch::from(self::ffi()->uiAttributeStretch($attr));
    }

    /**
     * 创建颜色属性
     *
     * @param float $r 红色
     * @param float $g 绿色
     * @param float $b 蓝色
     * @param float $a 透明度
     * @return CData 属性句柄
     */
    public static function createColor(float $r, float $g, float $b, float $a): CData
    {
        return self::ffi()->uiNewColorAttribute($r, $g, $b, $a);
    }

    /**
     * 获取颜色属性值
     *
     * @param CData $attr 属性句柄
     * @return array 颜色值
     */
    public static function color(CData $attr): array
    {
        $r = 0.0;
        $g = 0.0;
        $b = 0.0;
        $a = 0.0;
        self::ffi()->uiAttributeColor($attr, $r, $g, $b, $a);
        return [$r, $g, $b, $a];
    }

    /**
     * 创建背景属性
     *
     * @param float $r 红色
     * @param float $g 绿色
     * @param float $b 蓝色
     * @param float $a 透明度
     * @return CData 属性句柄
     */
    public static function createBackground(float $r, float $g, float $b, float $a): CData
    {
        return self::ffi()->uiNewBackgroundAttribute($r, $g, $b, $a);
    }

    /**
     * 创建下划线属性
     *
     * @param Underline $u
     * @return CData
     */
    public static function createUnderline(Underline $u): CData
    {
        return self::ffi()->uiNewUnderlineAttribute($u->value);
    }

    /**
     * 获取下划线属性值
     *
     * @param CData $attr 属性句柄
     * @return Underline 下划线
     */
    public static function underline(CData $attr): Underline
    {
        return Underline::from(self::ffi()->uiAttributeUnderline($attr));
    }

    /**
     * 创建下划线颜色属性
     *
     * @param UnderlineColor $c 下划线颜色
     * @param float $r 红色
     * @param float $g 绿色
     * @param float $b 蓝色
     * @param float $a 透明度
     * @return CData 属性句柄
     */
    public static function createUnderlineColor(UnderlineColor $c, float $r, float $g, float $b, float $a): CData
    {
        return self::ffi()->uiNewUnderlineColorAttribute($c->value, $r, $g, $b, $a);
    }

    /**
     * 获取下划线颜色属性值
     *
     * @param CData $attr 属性句柄
     * @return array 下划线颜色
     */
    public static function underlineColor(CData $attr): array
    {
        $c = 0;
        $r = 0.0;
        $g = 0.0;
        $b = 0.0;
        $a = 0.0;
        self::ffi()->uiAttributeUnderlineColor($attr, $c, $r, $g, $b, $a);
        return [UnderlineColor::from($c), $r, $g, $b, $a];
    }

    /**
     * 创建字符串属性
     *
     * @param string $initialString 初始字符串
     * @return CData 属性句柄
     */
    public static function createString(string $initialString): CData
    {
        return self::ffi()->uiNewAttributedString($initialString);
    }

    /**
     * 释放字符串属性
     *
     * @param CData $attr 属性句柄
     * @return void
     */
    public static function freeString(CData $attr): void
    {
        self::ffi()->uiFreeAttributedString($attr);
    }

    /**
     * 获取字符串属性值
     *
     * @param CData $attr 属性句柄
     * @return string 字符串
     */
    public static function stringString(CData $attr): string
    {
        return self::ffi()->uiAttributedStringString($attr);
    }

    /**
     * 字符串属性追加未格式化字符串
     *
     * @param CData $attr 属性句柄
     * @param string $s 字符串
     * @return void
     */
    public static function stringAppendUnattributed(CData $attr, string $s): void
    {
        self::ffi()->uiAttributedStringAppendUnattributed($attr, $s);
    }

    /**
     * 字符串属性插入未格式化字符串
     *
     * @param CData $attr 属性句柄
     * @param string $s 字符串
     * @param int $at 插入位置
     * @return void
     */
    public static function stringInsertAtUnattributed(CData $attr, string $s, int $at): void
    {
        self::ffi()->uiAttributedStringInsertAtUnattributed($attr, $s, $at);
    }

    /**
     * 字符串属性删除
     *
     * @param CData $attr 属性句柄
     * @param int $start 开始位置
     * @param int $end 结束位置
     * @return void
     */
    public static function stringDelete(CData $attr, int $start, int $end): void
    {
        self::ffi()->uiAttributedStringDelete($attr, $start, $end);
    }

    /**
     * 字符串属性设置属性
     *
     * @param CData $attrStr 字符串属性句柄
     * @param CData $attr 属性句柄
     * @param integer $start 开始位置
     * @param integer $end 结束位置
     * @return void
     */
    public static function stringSet(CData $attrStr, CData $attr, int $start, int $end): void
    {
        self::ffi()->uiAttributedStringSetAttribute($attrStr, $attr, $start, $end);
    }

    /**
     * 获取字符串属性 grapheme 数量
     *
     * @param CData $attr 属性句柄
     * @return int grapheme 数量
     */
    public static function stringNumGraphemes(CData $attr): int
    {
        return self::ffi()->uiAttributedStringNumGraphemes($attr);
    }

    /**
     * 获取字符串属性 grapheme 索引
     *
     * @param CData $attr 属性句柄
     * @param int $byteIndex 字节索引
     * @return int grapheme 索引
     */
    public static function stringByteIndexToGrapheme(CData $attr, int $byteIndex): int
    {
        return self::ffi()->uiAttributedStringByteIndexToGrapheme($attr, $byteIndex);
    }

    /**
     * 获取字符串属性 grapheme 字节索引
     *
     * @param CData $attr 属性句柄
     * @param int $graphemeIndex grapheme 索引
     * @return int 字节索引
     */
    public static function stringGraphemeToByteIndex(CData $attr, int $graphemeIndex): int
    {
        return self::ffi()->uiAttributedStringGraphemeToByteIndex($attr, $graphemeIndex);
    }
}
