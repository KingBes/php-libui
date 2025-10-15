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

// 性能优化：预计算颜色块，避免重复创建相同颜色的画笔
$colorCache = [];

// 创建绘画处理程序（完全遵循test/draw.php的Area::handler模式）
$areaHandler = Area::handler(
    // 绘画回调（优化后的绘制逻辑，使用颜色缓存和块绘制）
    function ($handler, $area, $params) use ($width, $height, $bytes, $imgX, $imgY, &$colorCache) {
        // 优化1：使用块绘制而非逐像素绘制
        $blockSize = 4; // 减小到4x4像素块

        // 处理完整的块
        for ($blockY = 0; $blockY < $height; $blockY += $blockSize) {
            for ($blockX = 0; $blockX < $width; $blockX += $blockSize) {
                // 计算实际块大小（处理边缘情况）
                $actualBlockWidth = min($blockSize, $width - $blockX);
                $actualBlockHeight = min($blockSize, $height - $blockY);
                
                // 获取块的第一个像素位置
                $firstPixelOffset = ($blockY * $width + $blockX) * 4;
                if ($firstPixelOffset + 3 >= strlen($bytes)) {
                    continue; // 超出范围检查
                }

                // 创建颜色哈希键（使用块内第一个像素作为基准）
                $colorKey = substr($bytes, $firstPixelOffset, 4);

                // 从缓存获取画笔，避免重复创建
                if (!isset($colorCache[$colorKey])) {
                    // 改进：计算块内所有像素的平均颜色
                    $totalR = 0;
                    $totalG = 0;
                    $totalB = 0;
                    $totalA = 0;
                    $pixelCount = 0;
                    
                    // 遍历块内所有像素
                    for ($by = 0; $by < $actualBlockHeight; $by++) {
                        for ($bx = 0; $bx < $actualBlockWidth; $bx++) {
                            $pixelOffset = (($blockY + $by) * $width + ($blockX + $bx)) * 4;
                            if ($pixelOffset + 3 < strlen($bytes)) {
                                $totalR += ord($bytes[$pixelOffset]);
                                $totalG += ord($bytes[$pixelOffset + 1]);
                                $totalB += ord($bytes[$pixelOffset + 2]);
                                $totalA += ord($bytes[$pixelOffset + 3]);
                                $pixelCount++;
                            }
                        }
                    }
                    
                    // 计算平均颜色
                    if ($pixelCount > 0) {
                        $r = ($totalR / $pixelCount) / 255;
                        $g = ($totalG / $pixelCount) / 255;
                        $b = ($totalB / $pixelCount) / 255;
                        $a = ($totalA / $pixelCount) / 255;
                    } else {
                        // 回退到第一个像素颜色
                        $r = ord($bytes[$firstPixelOffset]) / 255;
                        $g = ord($bytes[$firstPixelOffset + 1]) / 255;
                        $b = ord($bytes[$firstPixelOffset + 2]) / 255;
                        $a = ord($bytes[$firstPixelOffset + 3]) / 255;
                    }

                    // 缓存画笔
                    $colorCache[$colorKey] = Draw::createBrush(DrawBrushType::Solid, $r, $g, $b, $a);
                }

                // 创建块路径
                $blockPath = Draw::createPath(DrawFillMode::Winding);
                Draw::pathAddRectangle(
                    $blockPath,
                    $imgX + $blockX,
                    $imgY + $blockY,
                    $actualBlockWidth,
                    $actualBlockHeight
                );
                Draw::pathEnd($blockPath);

                // 填充块
                Draw::fill($params, $blockPath, $colorCache[$colorKey]);
            }
        }
    },
    // 按键事件
    function ($handler, $area, $keyEvent) {
        return 1;
    },
    // 鼠标事件
    function ($handler, $area, $mouseEvent) use (&$imgX, &$imgY) {}
);

// 创建绘画区域并添加到窗口
$area = Area::create($areaHandler);
Window::setChild($window, $area);

// 显示控件并启动主循环（遵循test/draw.php的启动流程）
Control::show($window);
App::main();
