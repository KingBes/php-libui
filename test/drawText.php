<?php

require dirname(__DIR__) . "/vendor/autoload.php";

use Kingbes\Libui\App;
use Kingbes\Libui\Window;
use Kingbes\Libui\Control;
use Kingbes\Libui\Area;
use Kingbes\Libui\Attribute;
use Kingbes\Libui\Draw;
use Kingbes\Libui\TextAlign;
use Kingbes\Libui\TextWeight;
use Kingbes\Libui\TextItalic;
use Kingbes\Libui\Underline;
use Kingbes\Libui\TextStretch;

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
$areaHandler = Area::handler(
    function ($handler, $area, $params) { // 绘画处理程序
        // 创建属性字符串
        $attrStr = Attribute::createString("hello world 你好世界!🤣");
        // 属性颜色
        $attrBlue = Attribute::createColor(0.0, 0.0, 1.0, 1.0); // 蓝色
        // 属性粗体
        $attrBole = Attribute::createWeight(TextWeight::Bold);
        // 字体大小
        $attrSize = Attribute::createSize(24.0);

        // 设置前5个字符的属性("hello") 为蓝色、粗体、大字体
        Attribute::stringSet($attrStr, $attrBlue, 0, 5); // 设置颜色
        Attribute::stringSet($attrStr, $attrBole, 0, 5); // 设置粗体
        Attribute::stringSet($attrStr, $attrSize, 0, 5); // 设置字体大小

        // 属性颜色
        $attrRed = Attribute::createColor(1.0, 0.0, 0.0, 1.0); // 红色
        // 设置后5个字符的属性("world") 为红色
        Attribute::stringSet($attrStr, $attrRed, 6, 11); // 设置颜色

        // 属性斜体
        $attrItalic = Attribute::createItalic(TextItalic::Italic);
        // 中文字体
        $attrFont = Attribute::createFamily("楷书");
        // 设置中文部分"你好"为斜体 宋体
        Attribute::stringSet($attrStr, $attrItalic, 11, 18); // 设置斜体
        Attribute::stringSet($attrStr, $attrFont, 11, 18); // 设置字体

        // 属性背景色
        $attrBg = Attribute::createBackground(0.0, 1.0, 0.0, 1.0); // 绿色
        // 属性下划线
        $attrUnderline = Attribute::createUnderline(Underline::Single); // 单下划线
        // 属性紫色
        $attrPurple = Attribute::createColor(0.5, 0.0, 0.5, 1.0); // 紫色

        // 设置"世界"的背景色和下划线 紫色
        Attribute::stringSet($attrStr, $attrPurple, 18, 25); // 设置紫色
        Attribute::stringSet($attrStr, $attrBg, 18, 25); // 设置背景色
        Attribute::stringSet($attrStr, $attrUnderline, 18, 25); // 设置下划线

        // emoji 字体
        $attrEmoji = Attribute::createFamily("Segoe UI Emoji");
        // 透明颜色
        $attrTransparent = Attribute::createColor(0.0, 0.0, 0.0, 0.0); // 透明
        
        // 设置emoji字体
        Attribute::stringSet($attrStr, $attrEmoji, 25, 29); // 设置emoji字体
        // 设置emoji字体颜色为透明
        Attribute::stringSet($attrStr, $attrTransparent, 25, 29); // 设置emoji字体颜色为透明（不然会显示为默认颜色）
        
        // 绘画
        $defaultFont = Draw::createFontDesc("宋体", 24.0, TextWeight::Normal, TextItalic::Normal, TextStretch::Normal); // 创建字体描述符
        $textLayoutParams = Draw::createTextLayoutParams(
            $attrStr,
            $defaultFont,
            400, // 文本布局的宽度，用于自动换行
            TextAlign::Left,
        ); //创建文本布局参数
        $drawText = Draw::createTextLayout($textLayoutParams); // 创建文件布局对象
        Draw::text($params, $drawText, 50, 50); // 绘制文本
    },
    function ($handler, $area, $keyEvent) { // 按键事件
        var_dump($keyEvent);
        echo "按键事件";
    },
    function ($handler, $area, $mouseEvent) { // 鼠标事件
        var_dump($mouseEvent);
        echo "鼠标事件";
    },
);

// 创建绘画区域
$area = Area::create($areaHandler);

Window::setChild($window, $area);

// 显示控件
Control::show($window);
// 主循环
App::main();
