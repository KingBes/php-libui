<?php

require dirname(__DIR__) . "/vendor/autoload.php";

use Kingbes\Libui\App;
use Kingbes\Libui\Window;
use Kingbes\Libui\Control;
use Kingbes\Libui\Button;
use Kingbes\Libui\Grid;
use Kingbes\Libui\Align;
use Kingbes\Libui\At;

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
// 创建网格布局
$grid = Grid::create();
// 网格布局设置边框
Grid::setPadded($grid, true);
// 网格布局添加控件
Grid::append($grid, Button::create("按钮"), 0, 0, 1, 1, 0, 0, 0, Align::Center);
Grid::append($grid, Button::create("按钮"), 1, 0, 1, 1, 0, 0, 0, Align::End);

// 设置窗口子元素
Window::setChild($window, $grid);

// 显示控件
Control::show($window);
// 主循环
App::main();
