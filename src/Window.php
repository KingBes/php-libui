<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 窗口类
 */
class Window extends Base
{
    /**
     * 获取窗口标题
     *
     * @param CData $window 窗口句柄
     * @return string
     */
    public static function title(CData $window): string
    {
        return self::ffi()->uiWindowTitle($window);
    }

    /**
     * 设置窗口标题
     *
     * @param CData $window 窗口句柄
     * @param string $title 窗口标题
     * @return void
     */
    public static function setTitle(CData $window, string $title): void
    {
        self::ffi()->uiWindowSetTitle($window, $title);
    }

    /**
     * 获取窗口位置
     *
     * @param CData $window 窗口句柄
     * @return array
     */
    public static function position(CData $window): array
    {
        $x = self::ffi()->cast("int*", self::ffi()->new("int"));
        $y = self::ffi()->cast("int*", self::ffi()->new("int"));
        self::ffi()->uiWindowPosition($window, $x, $y);
        return [$x[0], $y[0]];
    }

    /**
     * 设置窗口位置
     *
     * @param CData $window 窗口句柄
     * @param int $x 窗口横坐标
     * @param int $y 窗口纵坐标
     * @return void
     */
    public static function setPosition(CData $window, int $x, int $y): void
    {
        self::ffi()->uiWindowSetPosition($window, $x, $y);
    }

    /**
     * 窗口位置改变事件
     *
     * @param CData $window 窗口句柄
     * @param callable $callback 回调函数
     * @return void
     */
    public static function onPositionChanged(CData $window, callable $callback): void
    {
        $c_callback = function ($w, $d) use ($callback) {
            return $callback($w);
        };
        self::ffi()->uiWindowOnPositionChanged($window, $c_callback, null);
    }

    /**
     * 设置窗口内容大小
     *
     * @param CData $window 窗口句柄
     * @param integer $width 窗口宽度
     * @param integer $height 窗口高度
     * @return void
     */
    public static function setContentSize(CData $window, int $width, int $height): void
    {
        self::ffi()->uiWindowSetContentSize($window, $width, $height);
    }

    /**
     * 窗口是否全屏
     *
     * @param CData $window 窗口句柄
     * @return bool
     */
    public static function fullscreen(CData $window): bool
    {
        return self::ffi()->uiWindowFullscreen($window);
    }

    /**
     * 设置窗口是否全屏
     *
     * @param CData $window 窗口句柄
     * @param bool $fullscreen 是否全屏
     * @return void
     */
    public static function setFullscreen(CData $window, bool $fullscreen): void
    {
        self::ffi()->uiWindowSetFullscreen($window, $fullscreen ? 1 : 0);
    }

    /**
     * 窗口内容大小改变事件
     *
     * @param CData $window 窗口句柄
     * @param callable $callback 回调函数
     * @return void
     */
    public static function onContentSizeChanged(CData $window, callable $callback): void
    {
        $c_callback = function ($w, $d) use ($window, $callback) {
            return $callback($window, $d);
        };
        self::ffi()->uiWindowOnContentSizeChanged($window, $c_callback, null);
    }

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
     * 窗口是否无边框
     *
     * @param CData $window 窗口句柄
     * @return bool
     */
    public static function borderless(CData $window): bool
    {
        return self::ffi()->uiWindowBorderless($window);
    }

    /**
     * 设置窗口是否无边框
     *
     * @param CData $window 窗口句柄
     * @param boolean $borderless 是否无边框
     * @return void
     */
    public static function setBorderless(CData $window, bool $borderless): void
    {
        self::ffi()->uiWindowSetBorderless($window, $borderless ? 1 : 0);
    }

    /**
     * 设置窗口子元素
     *
     * @param CData $window 窗口句柄
     * @param CData $child 子元素句柄
     * @return void
     */
    public static function setChild(CData $window, CData $child): void
    {
        $uiChildPtr = self::ffi()->cast("uiControl*", $child);
        self::ffi()->uiWindowSetChild($window, $uiChildPtr);
    }

    /**
     * 窗口是否有边距
     *
     * @param CData $window 窗口句柄
     * @return boolean 是否有边距
     */
    public static function margined(CData $window): bool
    {
        return self::ffi()->uiWindowMargined($window);
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
            return $callback($window);
        };
        self::ffi()->uiWindowOnClosing($window, $c_callback, null);
    }

    /**
     * 窗口焦点改变事件
     *
     * @param CData $window 窗口句柄
     * @param callable $callback 回调函数
     * @return void
     */
    public static function onFocusChanged(CData $window, callable $callback): void
    {
        $c_callback = function ($w, $d) use ($callback) {
            return $callback($w);
        };
        self::ffi()->uiWindowOnFocusChanged($window, $c_callback, null);
    }

    /**
     * 窗口是否有焦点
     *
     * @param CData $window 窗口句柄
     * @return bool 是否有焦点
     */
    public static function focused(CData $window): bool
    {
        return self::ffi()->uiWindowFocused($window);
    }

    /**
     * 窗口是否可调整大小
     *
     * @param CData $window 窗口句柄
     * @return bool 是否可调整大小
     */
    public static function resizable(CData $window): bool
    {
        return self::ffi()->uiWindowResizable($window);
    }

    /**
     * 设置窗口是否可调整大小
     *
     * @param CData $windos 窗口句柄
     * @param boolean $resizeable 是否可调整大小
     * @return void
     */
    public static function setResizeable(CData $windos, bool $resizeable): void
    {
        self::ffi()->uiWindowSetResizable($windos, $resizeable ? 1 : 0);
    }

    /**
     * 设置窗口是否可调整大小
     *
     * @param CData $window 窗口句柄
     * @param bool $resizable 是否可调整大小
     * @return void
     */
    public static function setResizable(CData $window, bool $resizable): void
    {
        self::ffi()->uiWindowSetResizable($window, $resizable ? 1 : 0);
    }

    /**
     * 打开文件对话框
     *
     * @param CData $window
     * @return string
     */
    public static function openFile(CData $window): string
    {
        return self::ffi()->uiOpenFile($window) ?? '';
    }

    /**
     * 保存文件对话框
     *
     * @param CData $window
     * @return string
     */
    public static function saveFile(CData $window): string
    {
        return self::ffi()->uiSaveFile($window) ?? '';
    }

    /**
     * 消息框
     *
     * @param CData $parent 父窗口句柄
     * @param string $title 标题
     * @param string $desc 描述
     * @return void
     */
    public static function msgBox(CData $parent, string $title, string $desc): void
    {
        self::ffi()->uiMsgBox($parent, $title, $desc);
    }

    /**
     * 错误消息框
     *
     * @param CData $parent 父窗口句柄
     * @param string $title 标题
     * @param string $desc 描述
     * @return void
     */
    public static function msgBoxError(CData $parent, string $title, string $desc): void
    {
        self::ffi()->uiMsgBoxError($parent, $title, $desc);
    }
}
