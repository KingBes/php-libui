<?php

namespace Kingbes\Libui;

/**
 * 修饰键
 */
enum Modifiers: int
{
    case Ctrl = 1;
    case Alt = 2;
    case Shift = 4;
    case Super = 8;
}
