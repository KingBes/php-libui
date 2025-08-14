<?php

namespace Kingbes\Libui;

/**
 * 应用类
 */
class App extends Base
{
    /**
     * 初始化
     *
     * @param integer $size
     * @return void
     */
    public static function init(int $size = 1): void
    {
        $options = self::ffi()->new("uiInitOptions[$size]");
        $err = self::ffi()->uiInit($options);
        if ($err) {
            throw new \RuntimeException($err);
        }
    }

    /**
     * 退出初始化(一般PHP不需要)
     *
     * @return void
     */
    public static function unInit(): void
    {
        self::ffi()->uiUninit();
    }

    /**
     * 释放初始化错误(一般PHP不需要)
     *
     * @param string $err
     * @return void
     */
    public static function freeInitError(string $err): void
    {
        self::ffi()->uiFreeInitError($err);
    }


    /**
     * 主循环
     *
     * @return void
     */
    public static function main(): void
    {
        self::ffi()->uiMain();
    }

    /**
     * 主循环步骤
     *
     * @return void
     */
    public static function mainSteps(): void
    {
        self::ffi()->uiMainSteps();
    }

    /**
     * 退出主循环
     *
     * @return void
     */
    public static function quit(): void
    {
        self::ffi()->uiQuit();
    }

    /**
     * 队列主循环
     *
     * @param callable $callable
     * @return void
     */
    public static function queueMain(callable $callable): void
    {
        $c_callable = function ($data) use ($callable) {
            $callable($data);
        };
        self::ffi()->uiQueueMain($c_callable, null);
    }
}
