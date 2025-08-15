<?php

namespace Kingbes\Libui;

use FFI\CData;

/**
 * 特点/特征
 */
class Features extends Base
{
    /**
     * 创建特点/特征
     *
     * @return CData
     */
    public static function createOpenType(): CData
    {
        return self::ffi()->uiNewOpenTypeFeatures();
    }

    public static function freeOpenType(CData $features): void
    {
        self::ffi()->uiFreeOpenTypeFeatures($features);
    }

    /**
     * 克隆特点/特征
     *
     * @param CData $features
     * @return CData
     */
    public static function cloneOpenType(CData $features): CData
    {
        return self::ffi()->uiOpenTypeFeaturesClone($features);
    }

    /**
     * 添加特点/特征
     *
     * @param CData $features 特点/特征句柄
     * @param CData $a 特征标签的第一个字符
     * @param CData $b 特征标签的第二个字符
     * @param CData $c 特征标签的第三个字符
     * @param CData $d 特征标签的第四个字符
     * @param int $value 特征值

     * @return void
     */
    public static function addOpenType(CData $features, CData $a, CData $b, CData $c, CData $d, int $value): void
    {
        self::ffi()->uiOpenTypeFeaturesAdd($features, $a, $b, $c, $d, $value);
    }

    /**
     * 移除特点/特征
     *
     * @param CData $features 特点/特征句柄
     * @param CData $a 特征标签的第一个字符
     * @param CData $b 特征标签的第二个字符
     * @param CData $c 特征标签的第三个字符
     * @param CData $d 特征标签的第四个字符
     * @return void
     */
    public static function removeOpenType(CData $features, CData $a, CData $b, CData $c, CData $d): void
    {
        self::ffi()->uiOpenTypeFeaturesRemove($features, $a, $b, $c, $d);
    }

    /**
     * 获取特点/特征
     *
     * @param CData $features 特点/特征句柄
     * @param CData $a 特征标签的第一个字符
     * @param CData $b 特征标签的第二个字符
     * @param CData $c 特征标签的第三个字符
     * @param CData $d 特征标签的第四个字符
     * @return int 特征值
     */
    public static function getOpenType(CData $features, CData $a, CData $b, CData $c, CData $d): int
    {
        $value = 0;
        self::ffi()->uiOpenTypeFeaturesGet($features, $a, $b, $c, $d, $value);
        return $value;
    }

    /**
     * 创建属性
     *
     * @param CData $otf 特点/特征句柄
     * @return CData
     */
    public static function createAttribute(CData $otf): CData
    {
        return self::ffi()->uiNewFeaturesAttribute($otf);
    }

    /**
     * 获取属性的特点/特征
     *
     * @param CData $attr
     * @return CData
     */
    public static function attribute(CData $attr): CData
    {
        return self::ffi()->uiAttributeFeatures($attr);
    }
}
