<?php

require dirname(__DIR__) . "/vendor/autoload.php";

use Kingbes\Libui\App;
use Kingbes\Libui\Window;
use Kingbes\Libui\Control;
use Kingbes\Libui\Box;
use Kingbes\Libui\DateTimePicker;
use Kingbes\Libui\DateTime;

// 初始化应用
App::init();
// 创建窗口
$window = Window::create("窗口", 640, 480, 0);
// 窗口设置边框
Window::setMargined($window, true);
// 窗口关闭事件
Window::onClosing($window, function ($window) {
    echo "窗口关闭";
    // 退出应用
    App::quit();
    // 返回1：奏效,返回0：不奏效
    return 1;
});

// 创建水平容器
$box = Box::newVerticalBox();
Box::setPadded($box, true); // 设置边距
Window::setChild($window, $box); // 设置窗口子元素

// 创建日期时间选择器
$dateTimePicker = DateTimePicker::createDataTime();
// 创建日期选择器
$datePicker = DateTimePicker::createDate();
// 创建时间选择器
$timePicker = DateTimePicker::createTime();

// 设置时间为2023年
DateTimePicker::setTime($dateTimePicker, new DateTime(
    50,
    30,
    10,
    10,
    10,
    2023
));

// 追加按钮到容器
Box::append($box, $dateTimePicker, false);
Box::append($box, $datePicker, false);
Box::append($box, $timePicker, false);

//时间日期时间选择器事件
DateTimePicker::onChanged($dateTimePicker, function ($dateTimePicker) {
    echo "时间日期时间选择器事件";
    // 显示选中的事件
    var_dump(DateTimePicker::time($dateTimePicker));
});
//日期选择器事件
DateTimePicker::onChanged($datePicker, function ($datePicker) {
    echo "日期选择器事件";
    // 显示选中的事件
    var_dump(DateTimePicker::time($datePicker));
});
//时间选择器事件
DateTimePicker::onChanged($timePicker, function ($timePicker) {
    echo "时间选择器事件";
    // 显示选中的事件
    var_dump(DateTimePicker::time($timePicker));
});


// 显示控件
Control::show($window);
// 主循环
App::main();
