<?php

require dirname(__DIR__) . "/vendor/autoload.php";

use Kingbes\Libui\App;
use Kingbes\Libui\Window;
use Kingbes\Libui\Control;
use Kingbes\Libui\Menu;
use Kingbes\Libui\MenuItem;
use Kingbes\Libui\Label;

// 初始化应用
App::init();

// 创建菜单 (必须在创建窗口之前创建)
$menu = Menu::create("菜单");
$item1 = Menu::appendItem($menu, "子菜单一");
$item2 = Menu::appendItem($menu, "子菜单二");
// 追加复选菜单项
$checkItem = Menu::appendCheckItem($menu, "复选菜单项");
// 追加分割线
Menu::appendSeparator($menu);
// 追加退出菜单项
$quitItem = Menu::appendQuitItem($menu);
// 追加关于菜单项
$aboutItem = Menu::appendAboutItem($menu);
// 追加首选项菜单项
$preferencesItem = Menu::appendPreferencesItem($menu);

// 子菜单点击事件
MenuItem::onClicked($item2, function ($item2, $w) {
    echo "子菜单二被点击了\n";
});

// 创建窗口
$window = Window::create("窗口", 640, 480, 1);

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

// 创建标签
$label = Label::create("这是一个标签");
// 将标签设置到窗口
Window::setChild($window, $label);

// 显示控件
Control::show($window);
// 主循环
App::main();
