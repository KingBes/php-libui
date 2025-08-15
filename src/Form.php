<?php

namespace Kingbes\Libui;

use FFI\CData;

/**
 * 表单
 */
class Form extends Base
{

    /**
     * 追加表单项
     *
     * @param CData $f 表单句柄
     * @param string $lable 标签
     * @param CData $c 控件句柄
     * @param bool $stretchy 是否拉伸
     * @return void
     */
    public static function append(CData $f, string $lable, CData $c, bool $stretchy): void
    {
        self::ffi()->uiFormAppend($f, $lable, $c, $stretchy ? 1 : 0);
    }

    /**
     * 删除表单项
     *
     * @param CData $f 表单句柄
     * @param int $index 索引
     * @return void
     */
    public static function delete(CData $f, int $index): void
    {
        self::ffi()->uiFormDelete($f, $index);
    }

    /**
     * 判断表单是否填充
     *
     * @param CData $f 表单句柄
     * @return bool
     */
    public static function padded(CData $f): bool
    {
        return self::ffi()->uiFormPadded($f);
    }

    /**
     * 设置表单是否填充
     *
     * @param CData $f 表单句柄
     * @param bool $padded 是否填充
     * @return void
     */
    public static function setPadded(CData $f, bool $padded): void
    {
        self::ffi()->uiFormSetPadded($f, $padded ? 1 : 0);
    }

    /**
     * 创建表单
     *
     * @return CData
     */
    public static function create(): CData
    {
        return self::ffi()->uiNewForm();
    }
}
