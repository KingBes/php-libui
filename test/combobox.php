<?php

require dirname(__DIR__) . "/vendor/autoload.php";

use Kingbes\Libui\App;
use Kingbes\Libui\Window;
use Kingbes\Libui\Control;
use Kingbes\Libui\Box;
use Kingbes\Libui\Combobox;

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

// 创建组合框
$combobox = Combobox::create();
// 追加选项
Combobox::append($combobox, "选项1");
Combobox::append($combobox, "选项2");
Combobox::append($combobox, "选项3");

// 默认选中 选项2
Combobox::setSelected($combobox, 1); // 索引从0开始

// 事件
Combobox::onSelected($combobox, function ($combobox) {
    $selected = Combobox::selected($combobox);
    echo "当前选中：" . $selected . "\n";
});

// 追加到容器
Box::append($box, $combobox, false);

// 显示控件
Control::show($window);
// 主循环
App::main();
