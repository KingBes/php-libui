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
     * @return DateTime 时间类
     */
    public static function time(CData $dateTimePicker): DateTime
    {
        $c_tm = self::ffi()->new("struct tm [1]");
        self::ffi()->uiDateTimePickerTime($dateTimePicker, $c_tm);
        $tm = new DateTime(
            $c_tm[0]->tm_sec,
            $c_tm[0]->tm_min,
            $c_tm[0]->tm_hour,
            $c_tm[0]->tm_mday,
            $c_tm[0]->tm_mon + 1,
            $c_tm[0]->tm_year + 1900,
            $c_tm[0]->tm_wday + 1,
            $c_tm[0]->tm_yday,
            $c_tm[0]->tm_isdst,
        );
        unset($c_tm);
        return $tm;
    }

    /**
     * 设置时间
     *
     * @param CData $dateTimePicker 日期时间选择器句柄
     * @param DateTime $time 时间类
     * @return void
     */
    public static function setTime(CData $dateTimePicker, DateTime $time)
    {
        $c_tm = self::ffi()->new("struct tm [1]");
        $c_tm[0]->tm_sec = $time->sec;
        $c_tm[0]->tm_min = $time->min;
        $c_tm[0]->tm_hour = $time->hour;
        $c_tm[0]->tm_mday = $time->mday;
        $c_tm[0]->tm_mon = $time->mon - 1;
        $c_tm[0]->tm_year = $time->year - 1900;
        $c_tm[0]->tm_wday = $time->wday - 1;
        $c_tm[0]->tm_yday = $time->yday;
        $c_tm[0]->tm_isdst = $time->isdst;
        self::ffi()->uiDateTimePickerSetTime($dateTimePicker, $c_tm);
        unset($c_tm);
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
                return $callback($dateTimePicker);
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
