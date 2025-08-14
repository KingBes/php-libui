<?php

namespace Kingbes\Libui;

use \FFI\CData;

class Control extends Base
{
    public static function show(CData $control): void
    {
        $uiControlPtr = self::ffi()->cast("uiControl*", $control);
        self::ffi()->uiControlShow($uiControlPtr);
    }
}
