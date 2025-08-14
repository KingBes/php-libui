<?php

namespace Kingbes\Libui;

use \FFI\CData;

class Window extends Base
{
    /**
     * 创建窗口
     *
     * @param string $title 窗口标题
     * @param integer $width 窗口宽度
     * @param integer $height 窗口高度
     * @param integer $hasMenubar 是否有菜单条
     * @return CData
     */
    public static function create(string $title, int $width, int $height, int $hasMenubar): CData
    {
        return self::ffi()->uiNewWindow($title, $width, $height, $hasMenubar);
    }

    /**
     * 设置窗口是否有边距
     *
     * @param bool $margined 是否有边距
     * @return void
     */
    public static function setMargined(CData $window, bool $margined): void
    {
        self::ffi()->uiWindowSetMargined($window, $margined ? 1 : 0);
    }

    /**
     * 窗口关闭事件
     *
     * @param CData $window
     * @param callable $callback
     * @return void
     */
    public static function onClosing(CData $window, callable $callback): void
    {
        $c_callback = function ($w, $d) use ($window, $callback) {
            return $callback($window, $d);
        };
        self::ffi()->uiWindowOnClosing($window, $c_callback, null);
    }
}
