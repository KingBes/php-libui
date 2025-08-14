<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 分隔符
 */
class Separator extends Base
{
    /**
     * 创建水平分隔符
     *
     * @return CData
     */
    public static function createHorizontal(): CData
    {
        return self::ffi()->uiNewHorizontalSeparator();
    }

    /**
     * 创建垂直分隔符
     *
     * @return CData
     */
    public static function createVertical(): CData
    {
        return self::ffi()->uiNewVerticalSeparator();
    }

}
