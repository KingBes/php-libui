<?php
require dirname(__DIR__) . "/vendor/autoload.php";
use Kingbes\Libui\App;
use Kingbes\Libui\Window;
use Kingbes\Libui\Control;
use Kingbes\Libui\Area;
use Kingbes\Libui\Box;
use Kingbes\Libui\Label;
use Kingbes\Libui\Draw;
use Kingbes\Libui\DrawBrushType;
use Kingbes\Libui\DrawFillMode;

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
    'nextShape' => [],  // 下一个方块形状
    'nextColor' => 0,   // 下一个方块颜色
    'score' => 0,
    'lives' => 3,  // 生命数量
    'gameOver' => false,
    'speed' => 1000, // 初始速度(毫秒)
    'lastFallTime' => 0
];

// 全局变量用于存储area引用
$areaRef = null;
// 全局变量用于控制定时器
$fallingTimerRunning = false;
// 全局变量用于存储Label控件引用
$scoreLabel = null;
$livesLabel = null;
$nextShapeArea = null;
$controlsLabel = null;

// 初始化应用
App::init();

// 创建窗口
$window = Window::create("俄罗斯方块", GRID_WIDTH * BLOCK_SIZE + 150, GRID_HEIGHT * BLOCK_SIZE + 50, 0);
Window::setMargined($window, true);

// 窗口关闭事件
Window::onClosing($window, function ($window) {
    App::quit();
    return 1;
});

// 创建主水平布局
$mainLayout = Box::newHorizontalBox();
Box::setPadded($mainLayout, true);
Window::setChild($window, $mainLayout);

// 创建垂直布局用于游戏区域
$gameLayout = Box::newVerticalBox();
Box::setPadded($gameLayout, true);
Box::append($mainLayout, $gameLayout, 1);

// 创建标签显示"Game"
$gameLabel = Label::create("Game");
Box::append($gameLayout, $gameLabel, 0);

// 生成新方块
function spawnNewShape(&$gameState)
{
    global $shapes, $livesLabel, $nextShapeArea, $scoreLabel;

    // 如果下一个方块不存在，生成一个
    if (empty($gameState['nextShape'])) {
        $nextShapeIndex = rand(0, count($shapes) - 1);
        $gameState['nextShape'] = $shapes[$nextShapeIndex];
        $gameState['nextColor'] = $nextShapeIndex + 1;
    }

    // 使用下一个方块作为当前方块
    $gameState['currentShape'] = $gameState['nextShape'];
    $gameState['currentColor'] = $gameState['nextColor'];

    // 生成新的下一个方块
    $nextShapeIndex = rand(0, count($shapes) - 1);
    $gameState['nextShape'] = $shapes[$nextShapeIndex];
    $gameState['nextColor'] = $nextShapeIndex + 1;

    // 计算初始位置（居中）
    $shapeWidth = count($gameState['currentShape'][0]);
    $gameState['currentX'] = (int)(GRID_WIDTH / 2 - $shapeWidth / 2);
    $gameState['currentY'] = 0;

    // 检查游戏是否结束
    if (checkCollision($gameState)) {
        // 减少生命
        $gameState['lives']--;
        
        // 更新生命值显示
        if ($livesLabel) {
            Label::setText($livesLabel, "生命: " . $gameState['lives']);
        }
        
        // 清空游戏网格
        $gameState['grid'] = array_fill(0, GRID_HEIGHT, array_fill(0, GRID_WIDTH, 0));
        
        // 如果生命用完，游戏结束
        if ($gameState['lives'] <= 0) {
            $gameState['gameOver'] = true;
            // 停止定时器
            global $fallingTimerRunning;
            $fallingTimerRunning = false;
            // 清空当前方块，避免继续绘制
            $gameState['currentShape'] = [];
            $gameState['currentColor'] = 0;
        } else {
            // 重置当前方块，重新生成
            $gameState['currentShape'] = [];
            $gameState['currentColor'] = 0;
        }
    }
    
    // 重绘下一个方块预览区域
    if ($nextShapeArea) {
        Area::queueRedraw($nextShapeArea);
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
    // 检查当前形状是否存在
    if (empty($gameState['currentShape'])) {
        return;
    }
    
    $originalShape = $gameState['currentShape'];
    $shapeHeight = count($originalShape);
    $shapeWidth = count($originalShape[0]);

    // 创建旋转后的形状
    $rotated = [];
    for ($x = 0; $x < $shapeWidth; $x++) {
        $rotatedRow = [];
        for ($y = $shapeHeight - 1; $y >= 0; $y--) {
            // 增加更多的边界检查
            if (isset($originalShape[$y]) && isset($originalShape[$y][$x])) {
                $rotatedRow[] = $originalShape[$y][$x];
            } else {
                $rotatedRow[] = 0;
            }
        }
        $rotated[] = $rotatedRow;
    }

    // 保存当前坐标
    $originalX = $gameState['currentX'];
    $originalY = $gameState['currentY'];

    // 尝试旋转
    $gameState['currentShape'] = $rotated;

    // 检查是否需要调整位置以避免边界碰撞
    $rotatedHeight = count($rotated);
    $rotatedWidth = count($rotated[0]);
    
    // 检查右边界
    if ($gameState['currentX'] + $rotatedWidth > GRID_WIDTH) {
        $gameState['currentX'] = GRID_WIDTH - $rotatedWidth;
    }
    
    // 检查左边界
    if ($gameState['currentX'] < 0) {
        $gameState['currentX'] = 0;
    }

    // 如果旋转后碰撞，恢复原状和坐标
    if (checkCollision($gameState)) {
        $gameState['currentShape'] = $originalShape;
        $gameState['currentX'] = $originalX;
        $gameState['currentY'] = $originalY;
    }
}

// 将当前方块固定到网格上
function lockShapeToGrid(&$gameState)
{
    global $areaRef, $scoreLabel, $livesLabel, $nextShapeArea;
    
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
    
    // 检查是否需要重新生成方块（生命值减少的情况）
    if (empty($gameState['currentShape']) && $gameState['lives'] > 0) {
        spawnNewShape($gameState);
    }
    
    // 更新得分和生命值显示
    if ($scoreLabel) {
        Label::setText($scoreLabel, "得分: " . $gameState['score']);
    }
    if ($livesLabel) {
        Label::setText($livesLabel, "生命: " . $gameState['lives']);
    }
    
    // 重绘下一个方块预览区域
    if ($nextShapeArea) {
        Area::queueRedraw($nextShapeArea);
    }
    
    // 重启定时器
    if ($areaRef && !$gameState['gameOver']) {
        global $fallingTimerRunning;
        $fallingTimerRunning = false;  // 重置定时器状态
        startFallingTimer($gameState, $areaRef);
    }
}

// 消除填满的行
function clearLines(&$gameState)
{
    global $scoreLabel;
    
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
            // 速度增加后需要重启定时器
            global $fallingTimerRunning;
            $fallingTimerRunning = false;
        }
        
        // 更新得分显示
        if ($scoreLabel) {
            Label::setText($scoreLabel, "得分: " . $gameState['score']);
        }
    }
}

// 创建游戏区域处理程序
$areaHandler = Area::handler(
    function ($handler, $area, $params) use (&$gameState) { // 绘画处理程序
        // 绘制背景
        $bgBrush = Draw::createBrush(DrawBrushType::Solid, 0.07, 0.07, 0.07, 1.0); // 深灰色背景
        $bgPath = Draw::createPath(DrawFillMode::Winding);
        Draw::pathAddRectangle($bgPath, 0, 0, GRID_WIDTH * BLOCK_SIZE, GRID_HEIGHT * BLOCK_SIZE);
        Draw::pathEnd($bgPath);
        Draw::fill($params, $bgPath, $bgBrush);
        Draw::freePath($bgPath);

        // 绘制游戏区域背景
        $gameBgBrush = Draw::createBrush(DrawBrushType::Solid, 0.1, 0.1, 0.1, 1.0);
        $gameBgPath = Draw::createPath(DrawFillMode::Winding);
        Draw::pathAddRectangle($gameBgPath, 0, 0, GRID_WIDTH * BLOCK_SIZE, GRID_HEIGHT * BLOCK_SIZE);
        Draw::pathEnd($gameBgPath);
        Draw::fill($params, $gameBgPath, $gameBgBrush);
        Draw::freePath($gameBgPath);

        // 绘制网格线
        $lineBrush = Draw::createBrush(DrawBrushType::Solid, 0.2, 0.2, 0.2, 1.0);
        
        // 水平线
        for ($y = 0; $y <= GRID_HEIGHT; $y++) {
            $linePath = Draw::createPath(DrawFillMode::Winding);
            Draw::pathAddRectangle($linePath, 0, $y * BLOCK_SIZE, GRID_WIDTH * BLOCK_SIZE, 1);
            Draw::pathEnd($linePath);
            Draw::fill($params, $linePath, $lineBrush);
            Draw::freePath($linePath);
        }

        // 垂直线
        for ($x = 0; $x <= GRID_WIDTH; $x++) {
            $linePath = Draw::createPath(DrawFillMode::Winding);
            Draw::pathAddRectangle($linePath, $x * BLOCK_SIZE, 0, 1, GRID_HEIGHT * BLOCK_SIZE);
            Draw::pathEnd($linePath);
            Draw::fill($params, $linePath, $lineBrush);
            Draw::freePath($linePath);
        }

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
                    Draw::freePath($path);
                }
            }
        }

        // 绘制当前方块
        if (!$gameState['gameOver']) {
            $shape = $gameState['currentShape'];
            if (!empty($shape)) {
                $shapeHeight = count($shape);
                $shapeWidth = count($shape[0]);
                
                // 检查颜色索引是否有效
                if (isset($gameState['currentColor']) && isset(COLORS[$gameState['currentColor']])) {
                    $color = COLORS[$gameState['currentColor']];
                } else {
                    $color = [0.5, 0.5, 0.5, 1.0]; // 默认灰色
                }
                
                $brush = Draw::createBrush(DrawBrushType::Solid, $color[0], $color[1], $color[2], $color[3]);

                for ($y = 0; $y < $shapeHeight; $y++) {
                    for ($x = 0; $x < $shapeWidth; $x++) {
                        if (isset($shape[$y][$x]) && $shape[$y][$x]) {
                            $drawX = ($gameState['currentX'] + $x) * BLOCK_SIZE + 1;
                            $drawY = ($gameState['currentY'] + $y) * BLOCK_SIZE + 1;

                            $path = Draw::createPath(DrawFillMode::Winding);
                            Draw::pathAddRectangle($path, $drawX, $drawY, BLOCK_SIZE - 2, BLOCK_SIZE - 2);
                            Draw::pathEnd($path);
                            Draw::fill($params, $path, $brush);
                            Draw::freePath($path);
                        }
                    }
                }
            }
        }

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
            Draw::freePath($overPath);
        }
        
        },
    function ($handler, $area, $keyEvent) use (&$gameState) { // 按键事件
        // 只在按键按下时处理（忽略按键释放事件）
        if ($keyEvent->Up) {
            return 1;
        }
        
        // 按R键重新开始（无论游戏是否结束）
        if ($keyEvent->Key == 'r' || $keyEvent->Key == 'R') {
            $gameState['grid'] = array_fill(0, GRID_HEIGHT, array_fill(0, GRID_WIDTH, 0));
            $gameState['score'] = 0;
            $gameState['lives'] = 3;  // 重置生命
            $gameState['gameOver'] = false;
            $gameState['speed'] = 1000;
            
            // 更新所有Label控件
            global $scoreLabel, $livesLabel, $nextShapeArea;
            if ($scoreLabel) {
                Label::setText($scoreLabel, "得分: 0");
            }
            if ($livesLabel) {
                Label::setText($livesLabel, "生命: 3");
            }
            
            // 重新生成新方块
            $gameState['currentShape'] = [];
            $gameState['currentColor'] = 0;
            spawnNewShape($gameState);
            Area::queueRedraw($area);
            
            // 重绘下一个方块预览区域
            if ($nextShapeArea) {
                Area::queueRedraw($nextShapeArea);
            }
            
            return 1;
        }
        
        if ($gameState['gameOver']) {
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
    },
    function ($handler, $area, $mouseEvent) { // 鼠标事件
        // 空的鼠标事件处理程序
    }
);

// 创建游戏区域
$gameArea = Area::create($areaHandler);
$areaRef = $gameArea;  // 存储area引用
Box::append($gameLayout, $gameArea, 1);

// 创建垂直布局用于信息显示
$infoLayout = Box::newVerticalBox();
Box::setPadded($infoLayout, true);
Box::append($mainLayout, $infoLayout, 0);

// 创建得分标签
$scoreLabel = Label::create("得分: 0");
Box::append($infoLayout, $scoreLabel, 0);

// 创建生命标签
$livesLabel = Label::create("生命: 3");
Box::append($infoLayout, $livesLabel, 0);

// 创建下一个方块标签
$nextLabel = Label::create("下一个:");
Box::append($infoLayout, $nextLabel, 0);

// 创建下一个方块预览区域
$nextShapeHandler = Area::handler(
    function ($handler, $area, $params) use (&$gameState) { // 绘画处理程序
        // 绘制背景
        $bgBrush = Draw::createBrush(DrawBrushType::Solid, 0.1, 0.1, 0.1, 1.0);
        $bgPath = Draw::createPath(DrawFillMode::Winding);
        Draw::pathAddRectangle($bgPath, 0, 0, 120, 120);
        Draw::pathEnd($bgPath);
        Draw::fill($params, $bgPath, $bgBrush);
        Draw::freePath($bgPath);
        
        // 绘制下一个方块预览
        if (!empty($gameState['nextShape'])) {
            $nextShape = $gameState['nextShape'];
            $nextColor = COLORS[$gameState['nextColor']];
            $nextBrush = Draw::createBrush(DrawBrushType::Solid, $nextColor[0], $nextColor[1], $nextColor[2], $nextColor[3]);
            
            // 计算预览区域的中心位置
            $previewAreaSize = 120;
            $blockPreviewSize = 15;  // 预览方块大小，减小一些以适应所有形状
            $shapeHeight = count($nextShape);
            $shapeWidth = count($nextShape[0]);
            
            // 计算真正居中的位置（移除之前添加的偏移量）
            $previewX = ($previewAreaSize - $shapeWidth * $blockPreviewSize) / 2;
            $previewY = ($previewAreaSize - $shapeHeight * $blockPreviewSize) / 2;
            
            for ($y = 0; $y < $shapeHeight; $y++) {
                for ($x = 0; $x < $shapeWidth; $x++) {
                    if (isset($nextShape[$y][$x]) && $nextShape[$y][$x]) {
                        $path = Draw::createPath(DrawFillMode::Winding);
                        Draw::pathAddRectangle(
                            $path,
                            $previewX + $x * $blockPreviewSize,
                            $previewY + $y * $blockPreviewSize,
                            $blockPreviewSize - 1,
                            $blockPreviewSize - 1
                        );
                        Draw::pathEnd($path);
                        Draw::fill($params, $path, $nextBrush);
                        Draw::freePath($path);
                    }
                }
            }
        }
    }
);

$nextShapeArea = Area::create($nextShapeHandler);
Box::append($infoLayout, $nextShapeArea, 0);

// 创建控制说明标签
$controlsLabel = Label::create("控制:\nA - 左移\nD - 右移\nS - 下移\nW - 旋转\nR - 重新开始");
Box::append($infoLayout, $controlsLabel, 0);

function startFallingTimer(&$gameState, $area)
{   
    global $fallingTimerRunning;
    // 如果定时器已经在运行，则不启动新的定时器
    if ($fallingTimerRunning) {
        return;
    }
    
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

// 初始化游戏
// 生成下一个方块
$nextShapeIndex = rand(0, count($shapes) - 1);
$gameState['nextShape'] = $shapes[$nextShapeIndex];
$gameState['nextColor'] = $nextShapeIndex + 1;
spawnNewShape($gameState);

startFallingTimer($gameState, $gameArea);

// 显示窗口
Control::show($window);

// 主循环
App::main();