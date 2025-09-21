<?php

require dirname(__DIR__) . "/vendor/autoload.php";

use Kingbes\Libui\App;
use Kingbes\Libui\Window;
use Kingbes\Libui\Control;
use Kingbes\Libui\Draw;
use Kingbes\Libui\Area;
use Kingbes\Libui\DrawBrushType;
use Kingbes\Libui\DrawFillMode;

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



// 创建绘画处理程序
$areaHandler = Area::handler(function ($handler, $area, $params) {
    // 创建红色笔刷
    $redBrush = Draw::createBrush(DrawBrushType::Solid, 1.0, 0.0, 0.0, 1.0);
    
    // 创建方块路径
    $drawPath = Draw::createPath(DrawFillMode::Winding);
    // 绘制一个红色的方块
    Draw::pathAddRectangle($drawPath, 50, 50, 100, 100);
    // 结束路径定义
    Draw::pathEnd($drawPath);
    // 填充方块
    Draw::fill($params[0]->Context, $drawPath, $redBrush);
});
// 创建绘画区域
$area = Area::create($areaHandler);

Window::setChild($window, $area);

// 显示控件
Control::show($window);
// 主循环
App::main();
