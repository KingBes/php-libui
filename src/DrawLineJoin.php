<?php

namespace Kingbes\Libui;

/**
 * 绘制线连接
 */
enum DrawLineJoin: int
{
    case Miter = 0; 
    case Round = 1;
    case Bevel = 2;
}
