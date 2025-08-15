<?php

namespace Kingbes\Libui;

/**
 * 属性类型
 */
enum AttributeType: int
{
    case Int = 0;
    case Double = 1;
    case String = 2;
    case Color = 3;
    case Font = 4;
    case Path = 5;
    case Image = 6;
    case Object = 7;
}
