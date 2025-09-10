<?php

namespace Kingbes\Libui;

/**
 * 日期时间
 * 
 * @var int $sec; 秒 [0, 60] 包括闰秒
 * @var int $min; 分 [0, 59]
 * @var int $hour; 时 [0, 23]
 * @var int $mday; 日 [1, 31]
 * @var int $mon; 月 [1, 12]
 * @var int $year; 年 自1900 年开始计算的年数
 * @var int $wday; 星期 [1, 7]
 * @var int $yday; 一年中的第几天 [0, 365]
 * @var int $isdst = -1; 夏令时标志 -1 表示不确定，0 表示不使用夏令时，1 表示使用夏令时
 * 
 * @package Kingbes\Libui
 */
class DateTime
{
    /**
     * 构造函数
     *
     * @param int $sec 秒 [0, 60] 包括闰秒
     * @param int $min 分 [0, 59]
     * @param int $hour 时 [0, 23]
     * @param int $mday 日 [1, 31]
     * @param int $mon 月 [1, 12]
     * @param int $year 年 自1900 年开始计算的年数
     * @param int $wday 星期 [1, 7]
     * @param int $yday 一年中的第几天 [0, 365]
     * @param int $isdst 夏令时标志 -1 表示不确定，0 表示不使用夏令时，1 表示使用夏令时
     */
    public function __construct(
        public int $sec = 0,
        public int $min = 0,
        public int $hour = 0,
        public int $mday = 0,
        public int $mon = 0,
        public int $year = 0,
        public int $wday = 0,
        public int $yday = 0,
        public int $isdst = -1,
    ) {}
}
