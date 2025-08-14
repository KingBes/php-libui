<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 微调框类
 */
class Spinbox extends Base
{
    /**
     * 获取微调框值
     *
     * @param CData $spinbox 微调框句柄
     * @return int
     */
    public static function value(CData $spinbox): int
    {
        return self::ffi()->uiSpinboxValue($spinbox);
    }

    /**
     * 设置微调框值
     *
     * @param CData $spinbox 微调框句柄
     * @param int $value 值
     * @return void
     */
    public static function setValue(CData $spinbox, int $value): void
    {
        self::ffi()->uiSpinboxSetValue($spinbox, $value);
    }

    /**
     * 微调框值改变事件
     *
     * @param CData $spinbox 微调框句柄
     * @param callable $callback 回调函数
     * @return void
     */
    public static function onChanged(CData $spinbox, callable $callback): void
    {
        self::ffi()->uiSpinboxOnChanged($spinbox, function ($s, $d)
        use ($callback, $spinbox) {
            $callback($spinbox);
        }, null);
    }

    /**
     * 创建微调框
     *
     * @param integer $min 最小值
     * @param integer $max 最大值
     * @return CData 微调框句柄
     */
    public static function create(int $min, int $max): CData
    {
        return self::ffi()->uiNewSpinbox($min, $max);
    }
}
