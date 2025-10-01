<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 滑块
 */
class Slider extends Base
{
    /**
     * 创建滑块
     *
     * @param integer $min 最小值
     * @param integer $max 最大值
     * @return CData
     */
    public static function create(int $min, int $max): CData
    {
        return self::ffi()->uiNewSlider($min, $max);
    }

    /**
     * 获取滑块值
     *
     * @param CData $slider 滑块句柄
     * @return int 滑块值
     */
    public static function value(CData $slider): int
    {
        return self::ffi()->uiSliderValue($slider);
    }

    /**
     * 设置滑块值
     *
     * @param CData $slider 滑块句柄
     * @param int $value 滑块值
     * @return void
     */
    public static function setValue(CData $slider, int $value): void
    {
        self::ffi()->uiSliderSetValue($slider, $value);
    }

    /**
     * 是否显示工具提示
     *
     * @param CData $slider 滑块句柄
     * @return bool
     */
    public static function hasToolTip(CData $slider): bool
    {
        return self::ffi()->uiSliderHasToolTip($slider);
    }

    /**
     * 设置是否显示工具提示
     *
     * @param CData $slider 滑块句柄
     * @param bool $hasToolTip 是否显示工具提示
     * @return void
     */
    public static function setHasToolTip(CData $slider, bool $hasToolTip): void
    {
        self::ffi()->uiSliderSetHasToolTip($slider, $hasToolTip ? 1 : 0);
    }

    /**
     * 滑块值改变事件
     *
     * @param CData $slider 滑块句柄
     * @param callable $callback 回调函数
     * @return void
     */
    public static function onChanged(CData $slider, callable $callback): void
    {
        self::ffi()->uiSliderOnChanged($slider, function ($s, $d)
        use ($callback, $slider) {
            $callback($slider);
        }, null);
    }

    /**
     * 滑块值释放事件
     *
     * @param CData $slider 滑块句柄
     * @param callable $callback 回调函数
     * @return void
     */
    public static function onReleased(CData $slider, callable $callback): void
    {
        self::ffi()->uiSliderOnReleased($slider, function ($s, $d)
        use ($callback) {
            $callback($s);
        }, null);
    }

    /**
     * 设置滑块范围
     *
     * @param CData $slider 滑块句柄
     * @param int $min 最小值
     * @param int $max 最大值
     * @return void
     */
    public static function setRange(CData $slider, int $min, int $max): void
    {
        self::ffi()->uiSliderSetRange($slider, $min, $max);
    }
}
