<?php

require dirname(__DIR__) . "/vendor/autoload.php";

use Kingbes\Libui\App;
use Kingbes\Libui\Window;
use Kingbes\Libui\Control;
use Kingbes\Libui\Group;
use Kingbes\Libui\Button;
use Kingbes\Libui\Box;

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

// 创建组
$group = Group::create("组");
// 组设置边框
Group::setMargined($group, true);

// 创建盒子
$box = Box::newVerticalBox();
// 盒子添加按钮
Box::append($box, Button::create("按钮"), false);

// 组添加按钮
Group::setChild($group, $box);
// 设置窗口子元素
Window::setChild($window, $group);

// 显示控件
Control::show($window);
// 主循环
App::main();
