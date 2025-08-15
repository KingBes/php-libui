<?php

namespace Kingbes\Libui;

/**
 * 绘制笔刷类型
 */
enum DrawBrushType: int
{
    case Solid = 0;
    case LinearGradient = 1;
    case RadialGradient = 2;
    case Image = 3;
}
