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

// 方块位置
$drawX = 50;
$drawY = 50;

$start_drop = false; // 可拖到状态

// 创建绘画处理程序
$areaHandler = Area::handler(
    function ($handler, $area, $params) use (&$drawX, &$drawY) { // 绘画处理程序
        // 创建红色笔刷
        $redBrush = Draw::createBrush(DrawBrushType::Solid, 1.0, 0.0, 0.0, 1.0);
        // 创建方块路径
        $drawPath = Draw::createPath(DrawFillMode::Winding);
        // 绘制一个红色的方块
        Draw::pathAddRectangle($drawPath, $drawX, $drawY, 100, 100);
        // 结束路径定义
        Draw::pathEnd($drawPath);
        // 填充方块
        Draw::fill($params, $drawPath, $redBrush);
    },
    function ($handler, $area, $keyEvent) { // 按键事件
        /* var_dump($area, $keyEvent);
        echo "按键事件";
        return 1; */
    },
    function ($handler, $area, $mouseEvent) use (&$drawX, &$drawY, &$start_drop) { // 鼠标事件
        var_dump($mouseEvent);
        if ($mouseEvent->Down == 1) { // 鼠标按下
            $start_drop = true; // 可拖到
        }
        if (
            $start_drop &&
            $mouseEvent->Held1To64 == 1 &&
            $mouseEvent->X <= $drawX + 100 &&
            $mouseEvent->Y <= $drawY + 100
        ) { // 判断是否在方块内，是否可拖到状态，是否长按状态
            $drawX = $mouseEvent->X - 50;
            $drawY = $mouseEvent->Y - 50;
            // 队列重绘
            Area::queueRedraw($area);
        }
        if ( // 鼠标松开,长按松开
            $mouseEvent->Held1To64 == 0 &&
            $mouseEvent->Down == 0
        ) {
            $start_drop = false; // 取消可拖到状态
        }
        // echo "鼠标事件";
    }
);

// 创建绘画区域
$area = Area::create($areaHandler);

Window::setChild($window, $area);

// 显示控件
Control::show($window);
// 主循环
App::main();
