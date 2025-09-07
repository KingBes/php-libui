<?php

require dirname(__DIR__) . "/vendor/autoload.php";

use Kingbes\Libui\App;
use Kingbes\Libui\Window;
use Kingbes\Libui\Control;
use Kingbes\Libui\Box;
use Kingbes\Libui\Table;
use Kingbes\Libui\TableValueType;

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

// 创建表格模型处理程序
$modelHandler = Table::modelHandler(
    2,
    TableValueType::String,
    3,
    function ($handler, $row, $column) {
        $name = ["小李", "小成", "多多"];
        $age = ["18", "20", "32"];

        if ($column == 0) {
            return Table::createValueStr((string)$name[$row]);
        } else {
            return Table::createValueStr((string)$age[$row]);
        }
    }
);
// 创建表格模型
$tableModel = Table::createModel($modelHandler);
// 创建表格
$table = Table::create($tableModel, -1);
// 表格追加文本列
Table::appendTextColumn($table, "姓名", 0, -1);
// 表格追加文本列
Table::appendTextColumn($table, "年龄", 1, -1);
// 追加表格到盒子
Box::append($box, $table, false);

// 显示控件
Control::show($window);
// 主循环
App::main();
