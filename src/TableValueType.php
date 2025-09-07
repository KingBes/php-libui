<?php

namespace Kingbes\Libui;

/**
 * 表格列类型
 */
enum TableValueType: int
{
    case String = 0;
    case Image = 1;
    case Int = 2;
    case Color = 3;
    case Null = 4;
}
