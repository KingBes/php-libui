<?php

namespace Kingbes\Libui;

enum TableSelectionMode: int
{
    case None = 0;
    case ZeroOrOne = 1;
    case One = 2;
    case ZeroOrMany = 3;
}
