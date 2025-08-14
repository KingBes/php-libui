<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 进度条
 */
class ProgressBar extends Base
{
    /**
     * 创建进度条
     *
     * @return CData
     */
    public static function create(): CData
    {
        return self::ffi()->uiNewProgressBar();
    }

    /**
     * 获取进度条值
     *
     * @param CData $progressBar 进度条句柄
     * @return int 进度条值
     */
    public static function value(CData $progressBar): int
    {
        return self::ffi()->uiProgressBarValue($progressBar);
    }

    /**
     * 设置进度条值
     *
     * @param CData $progressBar 进度条句柄
     * @param int $value 进度条值
     * @return void
     */
    public static function setValue(CData $progressBar, int $value): void
    {
        self::ffi()->uiProgressBarSetValue($progressBar, $value);
    }
}
