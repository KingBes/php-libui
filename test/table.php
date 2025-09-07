<?php

require dirname(__DIR__) . "/vendor/autoload.php";

use Kingbes\Libui\App;
use Kingbes\Libui\Window;
use Kingbes\Libui\Control;
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

// 创建表格模型处理程序
$modelHandler = Table::modelHandler(
    3, // 列数
    TableValueType::String, // 列类型
    3, // 行数
    function ($handler, $row, $column) { // 单元格值获取回调
        $name = ["小李", "小成", "多多"];
        $age = ["18", "20", "32"];
        $btn = ["编辑", "编辑", "编辑"];

        if ($column == 0) {
            return Table::createValueStr($name[$row]);
        } else if ($column == 1) {
            return Table::createValueStr($age[$row]);
        } else {
            return Table::createValueStr($btn[$row]);
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
// 表格追加按钮列
Table::appendButtonColumn($table, "操作", 2, -1);

Window::setChild($window, $table); // 设置窗口子元素

// 显示控件
Control::show($window);
// 主循环
App::main();
