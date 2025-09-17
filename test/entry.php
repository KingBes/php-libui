<?php

require dirname(__DIR__) . "/vendor/autoload.php";

use Kingbes\Libui\App;
use Kingbes\Libui\Window;
use Kingbes\Libui\Control;
use Kingbes\Libui\Box;
use Kingbes\Libui\Entry;

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

// 创建输入框
$entry = Entry::create();

Entry::onChanged($entry, function ($entry) {
    $text = Entry::text($entry);
    echo "当前输入：" . $text . "\n";
});

// 创建密码输入框
$pwdEntry = Entry::createPwd();
Entry::onChanged($pwdEntry, function ($pwdEntry) {
    $text = Entry::text($pwdEntry);
    echo "当前密码输入：" . $text . "\n";
});

// 创建搜索输入框
$searchEntry = Entry::create();
Entry::setText($searchEntry, "搜索..."); // 设置默认文本
Entry::onChanged($searchEntry, function ($searchEntry) {
    $text = Entry::text($searchEntry);
    echo "当前搜索输入：" . $text . "\n";
});

// 创建输入框2
$entry2 = Entry::create();
// 设置为只读
Entry::setReadOnly($entry2, true);
Entry::setText($entry2, "只读输入框"); // 设置默认文本

// 追加输入框2到容器
Box::append($box, $entry2, false);

// 追加搜索输入框到容器
Box::append($box, $searchEntry, false);

// 追加密码输入框到容器
Box::append($box, $pwdEntry, false);

// 追加输入框到容器
Box::append($box, $entry, false);



// 显示控件
Control::show($window);
// 主循环
App::main();
