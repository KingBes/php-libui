<?php

require dirname(__DIR__) . "/vendor/autoload.php";

use Kingbes\Libui\App;
use Kingbes\Libui\Window;
use Kingbes\Libui\Control;
use Kingbes\Libui\Box;
use Kingbes\Libui\Button;

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
// 创建按钮
$btn01 = Button::create("按钮");
// 追加按钮到容器
Box::append($box, $btn01, false);
// 按钮点击事件
Button::onClicked($btn01, function ($btn01) use ($window) {
    echo "按钮点击\n";
    Window::msgBox($window, "提示", "世界上最好的语言PHP~");
});

// 显示控件
Control::show($window);
// 主循环
App::main();
