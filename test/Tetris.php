<?php
require dirname(__DIR__) . "/vendor/autoload.php";

use Kingbes\Libui\App;
use Kingbes\Libui\Window;
use Kingbes\Libui\Control;
use Kingbes\Libui\Area;
use Kingbes\Libui\Draw;
use Kingbes\Libui\DrawBrushType;
use Kingbes\Libui\DrawFillMode;
use Kingbes\Libui\DrawLineJoin;
use Kingbes\Libui\DrawLineCap;

// 游戏常量
define('GRID_WIDTH', 10);    // 游戏区域宽度
define('GRID_HEIGHT', 20);   // 游戏区域高度
define('BLOCK_SIZE', 30);    // 方块大小(像素)
define('COLORS', [
    [0, 0, 0, 0],           // 空白
    [0, 0, 1, 1],           // 蓝色
    [0, 1, 0, 1],           // 绿色
    [1, 0, 0, 1],           // 红色
    [1, 1, 0, 1],           // 黄色
    [1, 0, 1, 1],           // 紫色
    [0, 1, 1, 1],           // 青色
    [1, 0.5, 0, 1]          // 橙色
]);

// 方块形状定义 (I, O, T, L, J, S, Z)
$shapes = [
    [[1, 1, 1, 1]],  // I
    [[1, 1], [1, 1]], // O
    [[0, 1, 0], [1, 1, 1]], // T
    [[0, 0, 1], [1, 1, 1]], // L
    [[1, 0, 0], [1, 1, 1]], // J
    [[0, 1, 1], [1, 1, 0]], // S
    [[1, 1, 0], [0, 1, 1]]  // Z
];

// 游戏状态
$gameState = [
    'grid' => array_fill(0, GRID_HEIGHT, array_fill(0, GRID_WIDTH, 0)),
    'currentShape' => [],
    'currentColor' => 0,
    'currentX' => 0,
    'currentY' => 0,
    'score' => 0,
    'gameOver' => false,
    'speed' => 1000, // 初始速度(毫秒)
    'lastFallTime' => 0
];

// 初始化应用
App::init();

// 创建窗口
$window = Window::create("俄罗斯方块", GRID_WIDTH * BLOCK_SIZE + 20, GRID_HEIGHT * BLOCK_SIZE + 60, 0);
Window::setMargined($window, true);

// 窗口关闭事件
Window::onClosing($window, function ($window) {
    App::quit();
    return 1;
});

// 生成新方块
function spawnNewShape(&$gameState)
{
    global $shapes;

    $shapeIndex = rand(0, count($shapes) - 1);
    $gameState['currentShape'] = $shapes[$shapeIndex];
    $gameState['currentColor'] = $shapeIndex + 1;

    // 计算初始位置（居中）
    $shapeWidth = count($gameState['currentShape'][0]);
    $gameState['currentX'] = (int)(GRID_WIDTH / 2 - $shapeWidth / 2);
    $gameState['currentY'] = 0;

    // 检查游戏是否结束
    if (checkCollision($gameState)) {
        $gameState['gameOver'] = true;
    }
}

// 检查碰撞
function checkCollision($gameState)
{
    $shape = $gameState['currentShape'];
    $shapeHeight = count($shape);
    $shapeWidth = count($shape[0]);

    for ($y = 0; $y < $shapeHeight; $y++) {
        for ($x = 0; $x < $shapeWidth; $x++) {
            if ($shape[$y][$x]) {
                $gridX = $gameState['currentX'] + $x;
                $gridY = $gameState['currentY'] + $y;
                // 检查边界碰撞
                if (
                    $gridX < 0 || $gridX >= GRID_WIDTH ||
                    $gridY >= GRID_HEIGHT ||
                    ($gridY >= 0 && $gameState['grid'][$gridY][$gridX])
                ) {
                    return true;
                }
            }
        }
    }
    return false;
}

// 旋转方块
function rotateShape(&$gameState)
{
    $originalShape = $gameState['currentShape'];
    $shapeHeight = count($originalShape);
    $shapeWidth = count($originalShape[0]);

    // 创建旋转后的形状
    $rotated = [];
    for ($x = 0; $x < $shapeWidth; $x++) {
        $rotatedRow = [];
        for ($y = $shapeHeight - 1; $y >= 0; $y--) {
            $rotatedRow[] = $originalShape[$y][$x];
        }
        $rotated[] = $rotatedRow;
    }

    // 尝试旋转
    $gameState['currentShape'] = $rotated;

    // 如果旋转后碰撞，恢复原状
    if (checkCollision($gameState)) {
        $gameState['currentShape'] = $originalShape;
    }
}

// 将当前方块固定到网格上
function lockShapeToGrid(&$gameState)
{
    $shape = $gameState['currentShape'];
    $shapeHeight = count($shape);
    $shapeWidth = count($shape[0]);

    for ($y = 0; $y < $shapeHeight; $y++) {
        for ($x = 0; $x < $shapeWidth; $x++) {
            if ($shape[$y][$x]) {
                $gridX = $gameState['currentX'] + $x;
                $gridY = $gameState['currentY'] + $y;

                if ($gridY >= 0) {
                    $gameState['grid'][$gridY][$gridX] = $gameState['currentColor'];
                }
            }
        }
    }

    clearLines($gameState);
    spawnNewShape($gameState);
}

// 消除填满的行
function clearLines(&$gameState)
{
    $linesCleared = 0;

    for ($y = GRID_HEIGHT - 1; $y >= 0; $y--) {
        $isLineComplete = true;
        for ($x = 0; $x < GRID_WIDTH; $x++) {
            if ($gameState['grid'][$y][$x] == 0) {
                $isLineComplete = false;
                break;
            }
        }

        if ($isLineComplete) {
            // 移除当前行并在顶部添加新行
            array_splice($gameState['grid'], $y, 1);
            array_unshift($gameState['grid'], array_fill(0, GRID_WIDTH, 0));
            $y++; // 检查新移下来的行
            $linesCleared++;
        }
    }

    // 根据消除的行数增加分数
    if ($linesCleared > 0) {
        $gameState['score'] += $linesCleared * 100;
        // 每消除10行增加速度
        if ($gameState['score'] % 1000 == 0 && $gameState['speed'] > 100) {
            $gameState['speed'] -= 50;
        }
    }
}

// 初始化游戏
spawnNewShape($gameState);

// 创建绘画处理程序
$areaHandler = Area::handler(
    function ($handler, $area, $params) use (&$gameState) { // 绘画处理程序
        // 绘制背景
        $bgBrush = Draw::createBrush(DrawBrushType::Solid, 0.1, 0.1, 0.1, 1.0);
        $bgPath = Draw::createPath(DrawFillMode::Winding);
        Draw::pathAddRectangle($bgPath, 0, 0, GRID_WIDTH * BLOCK_SIZE, GRID_HEIGHT * BLOCK_SIZE);
        Draw::pathEnd($bgPath);
        Draw::fill($params, $bgPath, $bgBrush);

        // 绘制网格线
        $lineBrush = Draw::createBrush(DrawBrushType::Solid, 0.2, 0.2, 0.2, 1.0);
        $linePath = Draw::createPath(DrawFillMode::Winding);

        // 水平线
        for ($y = 0; $y <= GRID_HEIGHT; $y++) {
            Draw::createPathFigure($linePath, 0, $y * BLOCK_SIZE);
            Draw::pathLineTo($linePath, GRID_WIDTH * BLOCK_SIZE, $y * BLOCK_SIZE);
        }

        // 垂直线
        for ($x = 0; $x <= GRID_WIDTH; $x++) {
            Draw::createPathFigure($linePath, $x * BLOCK_SIZE, 0);
            Draw::pathLineTo($linePath, $x * BLOCK_SIZE, GRID_HEIGHT * BLOCK_SIZE);
        }

        Draw::pathEnd($linePath);
        $strokeParams = Draw::createStrokeParams(
            DrawLineCap::Flat,
            DrawLineJoin::Miter,
            DrawLineJoin::Miter,
            1.0,
        );
        Draw::Stroke($params, $linePath, $lineBrush, $strokeParams);

        // 绘制已落下的方块
        for ($y = 0; $y < GRID_HEIGHT; $y++) {
            for ($x = 0; $x < GRID_WIDTH; $x++) {
                $colorIndex = $gameState['grid'][$y][$x];
                if ($colorIndex > 0) {
                    $color = COLORS[$colorIndex];
                    $brush = Draw::createBrush(DrawBrushType::Solid, $color[0], $color[1], $color[2], $color[3]);
                    $path = Draw::createPath(DrawFillMode::Winding);
                    Draw::pathAddRectangle(
                        $path,
                        $x * BLOCK_SIZE + 1,
                        $y * BLOCK_SIZE + 1,
                        BLOCK_SIZE - 2,
                        BLOCK_SIZE - 2
                    );
                    Draw::pathEnd($path);
                    Draw::fill($params, $path, $brush);
                }
            }
        }

        // 绘制当前方块
        if (!$gameState['gameOver']) {
            $shape = $gameState['currentShape'];
            $shapeHeight = count($shape);
            $shapeWidth = count($shape[0]);
            $color = COLORS[$gameState['currentColor']];
            $brush = Draw::createBrush(DrawBrushType::Solid, $color[0], $color[1], $color[2], $color[3]);

            for ($y = 0; $y < $shapeHeight; $y++) {
                for ($x = 0; $x < $shapeWidth; $x++) {
                    if ($shape[$y][$x]) {
                        $drawX = ($gameState['currentX'] + $x) * BLOCK_SIZE + 1;
                        $drawY = ($gameState['currentY'] + $y) * BLOCK_SIZE + 1;

                        $path = Draw::createPath(DrawFillMode::Winding);
                        Draw::pathAddRectangle($path, $drawX, $drawY, BLOCK_SIZE - 2, BLOCK_SIZE - 2);
                        Draw::pathEnd($path);
                        Draw::fill($params, $path, $brush);
                    }
                }
            }
        }

        // 绘制分数
        $scoreBrush = Draw::createBrush(DrawBrushType::Solid, 1, 1, 1, 1.0);
        $scorePath = Draw::createPath(DrawFillMode::Winding);
        Draw::pathAddRectangle($scorePath, 10, GRID_HEIGHT * BLOCK_SIZE + 10, 100, 30);
        Draw::pathEnd($scorePath);
        Draw::fill($params, $scorePath, $scoreBrush);

        // 绘制游戏结束信息
        if ($gameState['gameOver']) {
            $overBrush = Draw::createBrush(DrawBrushType::Solid, 1, 0, 0, 0.8);
            $overPath = Draw::createPath(DrawFillMode::Winding);
            Draw::pathAddRectangle(
                $overPath,
                GRID_WIDTH * BLOCK_SIZE / 4,
                GRID_HEIGHT * BLOCK_SIZE / 2 - 30,
                GRID_WIDTH * BLOCK_SIZE / 2,
                60
            );
            Draw::pathEnd($overPath);
            Draw::fill($params, $overPath, $overBrush);
        }
    },
    function ($handler, $area, $keyEvent) use (&$gameState) { // 按键事件

        if ($keyEvent->Up) {
            return 1;
        }

        if ($gameState['gameOver']) {
            // 游戏结束时按R键重新开始
            if ($keyEvent->Key == 'r' || $keyEvent->Key == 'R') {
                $gameState['grid'] = array_fill(0, GRID_HEIGHT, array_fill(0, GRID_WIDTH, 0));
                $gameState['score'] = 0;
                $gameState['gameOver'] = false;
                $gameState['speed'] = 1000;
                spawnNewShape($gameState);
                Area::queueRedraw($area);
            }
            return 1;
        }

        // 方向键控制
        switch ($keyEvent->Key) {
            case 'a':
                $gameState['currentX']--;
                if (checkCollision($gameState)) {
                    $gameState['currentX']++;
                }
                Area::queueRedraw($area);
                break;
            case 'd':
                $gameState['currentX']++;
                if (checkCollision($gameState)) {
                    $gameState['currentX']--;
                }
                Area::queueRedraw($area);
                break;
            case 's':
                $gameState['currentY']++;
                if (checkCollision($gameState)) {
                    $gameState['currentY']--;
                    lockShapeToGrid($gameState);
                }
                Area::queueRedraw($area);
                break;
            case 'w':
                rotateShape($gameState);
                Area::queueRedraw($area);
                break;
        }
        return 1;
    }
);

// 创建绘画区域
$area = Area::create($areaHandler);
Window::setChild($window, $area);

function startFallingTimer(&$gameState, $area)
{
    // 启动自动下落定时器
    App::timer($gameState['speed'], function () use ($area, &$gameState) {
        if (!$gameState['gameOver']) {
            $gameState['currentY']++;
            if (checkCollision($gameState)) {
                $gameState['currentY']--;
                lockShapeToGrid($gameState);
            }
            Area::queueRedraw($area);
            startFallingTimer($gameState, $area);
        }
    });
}

startFallingTimer($gameState, $area);

// 显示窗口
Control::show($window);
// 主循环
App::main();
