<?php
require dirname(__DIR__) . "/vendor/autoload.php";

use Kingbes\Libui\App;
use Kingbes\Libui\Window;
use Kingbes\Libui\Control;
use Kingbes\Libui\Area;
use Kingbes\Libui\Draw;
use Kingbes\Libui\DrawBrushType;
use Kingbes\Libui\DrawFillMode;
use Kingbes\Libui\Image;

// 初始化应用
App::init();

// 创建窗口
$window = Window::create("纯绘画方式显示图片", 800, 600, 0);
Window::setMargined($window, true);
Window::onClosing($window, function ($window) {
    App::quit();
    return 1;
});

// 图片相关参数
$imagePath = __DIR__ . "/qrcode.png"; 
$imgData = Image::imageToRGBA($imagePath); // 获取RGBA数据
if (!$imgData) {
    die("图片加载失败，请检查路径");
}
extract($imgData); // 提取width, height, bytes
$imgX = 50; // 图片绘制起始X坐标
$imgY = 50; // 图片绘制起始Y坐标

// 创建绘画处理程序（完全遵循test/draw.php的Area::handler模式）
$areaHandler = Area::handler(
    // 绘画回调（核心绘制逻辑，参考test/draw.php的方块绘制）
    function ($handler, $area, $params) use ($width, $height, $bytes, $imgX, $imgY) {
        // 2. 绘制图片（模拟像素级绘制，适配Draw类API）
        $pixelSize = 1; // 像素块大小（1=原始尺寸）
        for ($y = 0; $y < $height; $y++) {
            for ($x = 0; $x < $width; $x++) {
                // 从RGBA字节流中提取像素颜色（每4字节代表一个像素：R、G、B、A）
                $offset = ($y * $width + $x) * 4;
                $r = ord($bytes[$offset]) / 255;     // 转换为0-1范围
                $g = ord($bytes[$offset + 1]) / 255;
                $b = ord($bytes[$offset + 2]) / 255;
                $a = ord($bytes[$offset + 3]) / 255;

                // 创建当前像素的纯色画笔（参考test/draw.php的createBrush用法）
                $pixelBrush = Draw::createBrush(DrawBrushType::Solid, $r, $g, $b, $a);

                // 创建像素路径（绘制1x1的小方块模拟像素，参考test/draw.php的pathAddRectangle）
                $pixelPath = Draw::createPath(DrawFillMode::Winding);
                Draw::pathAddRectangle(
                    $pixelPath,
                    $imgX + $x * $pixelSize,  // 像素X坐标
                    $imgY + $y * $pixelSize,  // 像素Y坐标
                    $pixelSize,               // 像素宽度
                    $pixelSize                // 像素高度
                );
                Draw::pathEnd($pixelPath);

                // 填充像素（参考test/draw.php的fill调用）
                Draw::fill($params, $pixelPath, $pixelBrush);
            }
        }
    },
    // 按键事件
    function ($handler, $area, $keyEvent) {
        return 1;
    },
    // 鼠标事件
    function ($handler, $area, $mouseEvent) use (&$imgX, &$imgY) {
        
    }
);

// 创建绘画区域并添加到窗口
$area = Area::create($areaHandler);
Window::setChild($window, $area);

// 显示控件并启动主循环（遵循test/draw.php的启动流程）
Control::show($window);
App::main();