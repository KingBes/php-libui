<?php

require dirname(__DIR__) . "/vendor/autoload.php";

use Kingbes\Libui\App;
use Kingbes\Libui\Window;
use Kingbes\Libui\Control;
use Kingbes\Libui\Box;
use Kingbes\Libui\Checkbox;

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

// 创建复选框
$checkbox = Checkbox::create("复选框");

// 追加复选框到容器
Box::append($box, $checkbox, false);

// 复选框点击事件
Checkbox::onToggled($checkbox, function ($checkbox) {
    echo "复选框状态：" . (Checkbox::checked($checkbox) ? "已选中" : "未选中") . "\n";
});

Window::setChild($window, $box); // 设置窗口子元素


// 显示控件
Control::show($window);
// 主循环
App::main();
