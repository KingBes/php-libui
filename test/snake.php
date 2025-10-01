<?php
require dirname(__DIR__) . "/vendor/autoload.php";

use Kingbes\Libui\App;
use Kingbes\Libui\Window;
use Kingbes\Libui\Control;
use Kingbes\Libui\Area;
use Kingbes\Libui\Draw;
use Kingbes\Libui\DrawBrushType;
use Kingbes\Libui\DrawFillMode;
use Kingbes\Libui\Attribute;
use Kingbes\Libui\TextAlign;
use Kingbes\Libui\TextWeight;
use Kingbes\Libui\TextItalic;
use Kingbes\Libui\TextStretch;
use Kingbes\Libui\DrawLineCap;
use Kingbes\Libui\DrawLineJoin;
use Kingbes\Libui\ExtKey;



// 游戏常量
define('GRID_WIDTH', 20);    // 网格宽度
define('GRID_HEIGHT', 20);   // 网格高度
define('BLOCK_SIZE', 25);    // 方块大小(像素)
define('DIRECTION_UP', 0);
define('DIRECTION_DOWN', 1);
define('DIRECTION_LEFT', 2);
define('DIRECTION_RIGHT', 3);

// 游戏状态
$gameState = [
    'snake' => [[10, 10], [9, 10], [8, 10]], // 蛇身体坐标
    'direction' => DIRECTION_RIGHT,          // 当前方向
    'nextDirection' => DIRECTION_RIGHT,      // 下一次移动方向
    'food' => [15, 10],                      // 食物位置
    'score' => 0,                            // 分数
    'gameOver' => false,                     // 游戏是否结束
    'speed' => 200,                          // 移动速度(毫秒)
    'paused' => false                        // 是否暂停
];

// 初始化应用
App::init();

// 创建窗口
$window = Window::create(
    "贪吃蛇",
    GRID_WIDTH * BLOCK_SIZE + 20,
    GRID_HEIGHT * BLOCK_SIZE + 100,
    0
);
Window::setMargined($window, true);

// 窗口关闭事件
Window::onClosing($window, function ($window) {
    App::quit();
    return 1;
});

// 生成新食物
function spawnFood(&$gameState)
{
    do {
        $x = rand(0, GRID_WIDTH - 1);
        $y = rand(0, GRID_HEIGHT - 1);
        $onSnake = false;

        // 检查是否生成在蛇身上
        foreach ($gameState['snake'] as $segment) {
            if ($segment[0] == $x && $segment[1] == $y) {
                $onSnake = true;
                break;
            }
        }
    } while ($onSnake);

    $gameState['food'] = [$x, $y];
}

// 移动蛇
function moveSnake(&$gameState)
{
    if ($gameState['gameOver'] || $gameState['paused']) return;

    // 更新方向
    $gameState['direction'] = $gameState['nextDirection'];

    // 获取头部位置
    $head = $gameState['snake'][0];
    $newHead = $head;

    // 根据方向计算新头部位置
    switch ($gameState['direction']) {
        case DIRECTION_UP:
            $newHead[1]--;
            break;
        case DIRECTION_DOWN:
            $newHead[1]++;
            break;
        case DIRECTION_LEFT:
            $newHead[0]--;
            break;
        case DIRECTION_RIGHT:
            $newHead[0]++;
            break;
    }

    // 碰撞检测
    // 边界碰撞
    if (
        $newHead[0] < 0 || $newHead[0] >= GRID_WIDTH ||
        $newHead[1] < 0 || $newHead[1] >= GRID_HEIGHT
    ) {
        $gameState['gameOver'] = true;
        return;
    }

    // 自身碰撞
    foreach ($gameState['snake'] as $segment) {
        if ($segment[0] == $newHead[0] && $segment[1] == $newHead[1]) {
            $gameState['gameOver'] = true;
            return;
        }
    }

    // 添加新头部
    array_unshift($gameState['snake'], $newHead);

    // 检查是否吃到食物
    if ($newHead[0] == $gameState['food'][0] && $newHead[1] == $gameState['food'][1]) {
        $gameState['score'] += 10;
        // 每得50分加快速度
        if ($gameState['score'] % 50 == 0 && $gameState['speed'] > 100) {
            $gameState['speed'] -= 10;
        }
        spawnFood($gameState);
    } else {
        // 没吃到食物则移除尾部
        array_pop($gameState['snake']);
    }
}

// 重新开始游戏
function restartGame(&$gameState)
{
    $gameState['snake'] = [[10, 10], [9, 10], [8, 10]];
    $gameState['direction'] = DIRECTION_RIGHT;
    $gameState['nextDirection'] = DIRECTION_RIGHT;
    $gameState['score'] = 0;
    $gameState['gameOver'] = false;
    $gameState['speed'] = 200;
    $gameState['paused'] = false;
    spawnFood($gameState);
}

// 创建绘画处理程序
$areaHandler = Area::handler(
    function ($handler, $area, $params) use (&$gameState) { // 绘画处理程序
        // 绘制背景
        $bgBrush = Draw::createBrush(DrawBrushType::Solid, 0.1, 0.1, 0.1, 1.0);
        $bgPath = Draw::createPath(DrawFillMode::Winding);
        Draw::pathAddRectangle(
            $bgPath,
            0,
            0,
            GRID_WIDTH * BLOCK_SIZE,
            GRID_HEIGHT * BLOCK_SIZE
        );
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
        $strokeParams = Draw::createStrokeParams(DrawLineCap::Round, DrawLineJoin::Miter, DrawLineJoin::Miter, 1.0);
        Draw::stroke($params, $linePath, $lineBrush, $strokeParams);

        // 绘制蛇
        foreach ($gameState['snake'] as $index => $segment) {
            // 头部用不同颜色
            if ($index == 0) {
                $brush = Draw::createBrush(DrawBrushType::Solid, 0, 1, 0, 1.0); // 绿色头部
            } else {
                $brush = Draw::createBrush(DrawBrushType::Solid, 0, 0.8, 0, 1.0); // 深绿身体
            }

            $path = Draw::createPath(DrawFillMode::Winding);
            Draw::pathAddRectangle(
                $path,
                $segment[0] * BLOCK_SIZE + 1,
                $segment[1] * BLOCK_SIZE + 1,
                BLOCK_SIZE - 2,
                BLOCK_SIZE - 2
            );
            Draw::pathEnd($path);
            Draw::fill($params, $path, $brush);
        }

        // 绘制食物
        $foodBrush = Draw::createBrush(DrawBrushType::Solid, 1, 0, 0, 1.0); // 红色食物
        $foodPath = Draw::createPath(DrawFillMode::Winding);
        Draw::pathAddRectangle(
            $foodPath,
            $gameState['food'][0] * BLOCK_SIZE + 1,
            $gameState['food'][1] * BLOCK_SIZE + 1,
            BLOCK_SIZE - 2,
            BLOCK_SIZE - 2
        );
        Draw::pathEnd($foodPath);
        Draw::fill($params, $foodPath, $foodBrush);

        // 绘制分数
        $scoreText = "分数: " . $gameState['score'];
        $scoreAttr = Attribute::createString($scoreText);
        $scoreColor = Attribute::createColor(1, 0.5, 0.5, 1); // 粉红色
        Attribute::stringSet($scoreAttr, $scoreColor, 0, strlen($scoreText));

        $font = Draw::createFontDesc("Arial", 16.0, TextWeight::Bold, TextItalic::Normal, TextStretch::Normal);
        $scoreLayout = Draw::createTextLayout(Draw::createTextLayoutParams(
            $scoreAttr,
            $font,
            GRID_WIDTH * BLOCK_SIZE,
            TextAlign::Left
        ));
        Draw::text($params, $scoreLayout, 10, GRID_HEIGHT * BLOCK_SIZE + 10);
        Draw::freeTextLayout($scoreLayout);

        // 绘制说明文字
        $instructions = "操作: 方向键控制  |  空格: 暂停  |  R: 重新开始";
        $instAttr = Attribute::createString($instructions);
        // 说明文字颜色
        $instColor = Attribute::createColor(0, 0, 1, 1); // 蓝色
        Attribute::stringSet($instAttr, $instColor, 0, strlen($instructions));
        $instLayout = Draw::createTextLayout(Draw::createTextLayoutParams(
            $instAttr,
            $font,
            GRID_WIDTH * BLOCK_SIZE,
            TextAlign::Left
        ));
        Draw::text($params, $instLayout, 10, GRID_HEIGHT * BLOCK_SIZE + 40);
        Draw::freeTextLayout($instLayout);

        // 游戏结束提示
        if ($gameState['gameOver']) {
            // 半透明背景
            $overBg = Draw::createBrush(DrawBrushType::Solid, 0, 0, 0, 0.7);
            $overBgPath = Draw::createPath(DrawFillMode::Winding);
            Draw::pathAddRectangle(
                $overBgPath,
                GRID_WIDTH * BLOCK_SIZE / 4,
                GRID_HEIGHT * BLOCK_SIZE / 2 - 40,
                GRID_WIDTH * BLOCK_SIZE / 2,
                80
            );
            Draw::pathEnd($overBgPath);
            Draw::fill($params, $overBgPath, $overBg);

            // 游戏结束文字
            $overText = "游戏结束! 得分: " . $gameState['score'];
            $overAttr = Attribute::createString($overText);
            $overWhite = Attribute::createColor(1, 1, 1, 1);
            Attribute::stringSet($overAttr, $overWhite, 0, strlen($overText));

            $overFont = Draw::createFontDesc("Arial", 18.0, TextWeight::Bold, TextItalic::Normal, TextStretch::Normal);
            $overLayout = Draw::createTextLayout(Draw::createTextLayoutParams(
                $overAttr,
                $overFont,
                GRID_WIDTH * BLOCK_SIZE / 2,
                TextAlign::Center
            ));
            Draw::text(
                $params,
                $overLayout,
                GRID_WIDTH * BLOCK_SIZE / 4,
                GRID_HEIGHT * BLOCK_SIZE / 2 - 20
            );
            Draw::freeTextLayout($overLayout);
        }

        // 暂停提示
        if ($gameState['paused'] && !$gameState['gameOver']) {
            $pauseText = "已暂停 (按空格继续)";
            $pauseAttr = Attribute::createString($pauseText);
            $pauseWhite = Attribute::createColor(1, 1, 1, 1);
            Attribute::stringSet($pauseAttr, $pauseWhite, 0, strlen($pauseText));

            $pauseFont = Draw::createFontDesc("Arial", 16.0, TextWeight::Bold, TextItalic::Normal, TextStretch::Normal);
            $pauseLayout = Draw::createTextLayout(Draw::createTextLayoutParams(
                $pauseAttr,
                $pauseFont,
                GRID_WIDTH * BLOCK_SIZE,
                TextAlign::Center
            ));
            Draw::text(
                $params,
                $pauseLayout,
                0,
                GRID_HEIGHT * BLOCK_SIZE / 2 - 10
            );
            Draw::freeTextLayout($pauseLayout);
        }
    },
    function ($handler, $area, $keyEvent) use (&$gameState) { // 按键事件
        var_dump($keyEvent);
        if ($keyEvent->Up) return 1; // 忽略释放键

        // 方向控制 (防止180度转向)
        if ($keyEvent->ExtKey == ExtKey::Up->value) {
            if ($gameState['direction'] != DIRECTION_DOWN) {
                $gameState['nextDirection'] = DIRECTION_UP;
            }
        }
        if ($keyEvent->ExtKey == ExtKey::Down->value) {
            if ($gameState['direction'] != DIRECTION_UP) {
                $gameState['nextDirection'] = DIRECTION_DOWN;
            }
        }
        if ($keyEvent->ExtKey == ExtKey::Left->value) {
            if ($gameState['direction'] != DIRECTION_RIGHT) {
                $gameState['nextDirection'] = DIRECTION_LEFT;
            }
        }
        if ($keyEvent->ExtKey == ExtKey::Right->value) {
            if ($gameState['direction'] != DIRECTION_LEFT) {
                $gameState['nextDirection'] = DIRECTION_RIGHT;
            }
        }
        // 空格暂停游戏
        if ($keyEvent->Key == ' ') {
            $gameState['paused'] = !$gameState['paused'];
            if (!$gameState['paused']) {
                startMoveTimer($gameState, $area);
            }
        }
        // R键重新开始游戏
        if ($keyEvent->Key == 'R' || $keyEvent->Key == 'r') {
            restartGame($gameState);
        }
        Area::queueRedraw($area);
        return 1;
    }
);

// 创建绘画区域
$area = Area::create($areaHandler);
Window::setChild($window, $area);

// 启动移动定时器
function startMoveTimer(&$gameState, $area)
{
    App::timer($gameState['speed'], function () use ($area, &$gameState) {
        moveSnake($gameState);
        Area::queueRedraw($area);
        startMoveTimer($gameState, $area);
    });
}

// 初始化游戏
spawnFood($gameState);
startMoveTimer($gameState, $area);

// 显示窗口
Control::show($window);
// 主循环
App::main();
