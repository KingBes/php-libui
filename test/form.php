<?php

require dirname(__DIR__) . "/vendor/autoload.php";

use Kingbes\Libui\App;
use Kingbes\Libui\Window;
use Kingbes\Libui\Control;
use Kingbes\Libui\Form;
use Kingbes\Libui\Entry;
use Kingbes\Libui\Checkbox;
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

// 创建表单
$form = Form::create();

// 创建输入框
$entry = Entry::create();
// 追加输入框到表单
Form::append($form, "输入框：", $entry, false);

// 创建复选框
$checkbox = Checkbox::create("复选框");
// 追加复选框到表单
Form::append($form, "复选框：", $checkbox, false);

// 创建按钮
$button = Button::create("按钮");
// 追加按钮到表单
Form::append($form, "按钮：", $button, false);

Window::setChild($window, $form); // 设置窗口子元素
// 显示控件
Control::show($window);
// 主循环
App::main();
