<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 日期时间选择器
 * 
 * 待办事项：记录 tm_wday 和 tm_yday 未定义，tm_isdst 应为 -1;
 * 待办事项：对双方都记录这一点;
 * 待办事项：记录时区转换或未转换的情况;
 * 待办事项：对于 Time：定义当某部分缺失时返回的值;
 */
class DateTimePicker extends Base
{

    /**
     * 获取时间
     *
     * @param CData $dateTimePicker 日期时间选择器句柄
     * @param CData $time 时间结构体指针
     * @return void
     */
    public static function time(CData $dateTimePicker, CData $time)
    {
        self::ffi()->uiDateTimePickerTime($dateTimePicker, $time);
    }

    /**
     * 设置时间
     *
     * @param CData $dateTimePicker 日期时间选择器句柄
     * @param CData $time 时间结构体指针
     * @return void
     */
    public static function setTime(CData $dateTimePicker, CData $time)
    {
        self::ffi()->uiDateTimePickerSetTime($dateTimePicker, $time);
    }

    /**
     * 时间改变事件
     *
     * @param CData $dateTimePicker 日期时间选择器句柄
     * @param callable $callback 回调函数
     * @return void
     */
    public static function onChanged(CData $dateTimePicker, callable $callback)
    {
        self::ffi()->uiDateTimePickerOnChanged(
            $dateTimePicker,
            function ($d, $dd) use ($dateTimePicker, $callback) {
                $callback($dateTimePicker);
            },
            null
        );
    }

    /**
     * 创建日期时间选择器
     *
     * @return CData
     */
    public static function createDataTime(): CData
    {
        return self::ffi()->uiNewDateTimePicker();
    }

    /**
     * 创建日期选择器
     *
     * @return CData
     */
    public static function createDate(): CData
    {
        return self::ffi()->uiNewDatePicker();
    }

    /**
     * 创建时间选择器
     *
     * @return CData
     */
    public static function createTime(): CData
    {
        return self::ffi()->uiNewTimePicker();
    }
}
