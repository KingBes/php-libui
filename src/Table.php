<?php

namespace Kingbes\Libui;

use \FFI\CData;

/**
 * 表格
 */
class Table extends Base
{
    /**
     * 释放表格值
     *
     * @param CData $value 表格值
     * @return void
     */
    public static function freeValue(CData $value): void
    {
        self::ffi()->uiFreeTableValue($value);
    }

    /**
     * 获取表格值类型
     *
     * @param CData $v 表格值
     * @return TableValueType 表格值类型
     */
    public static function getValueType(CData $v): TableValueType
    {
        return TableValueType::from(self::ffi()->uiTableValueGetType($v));
    }

    /**
     * 创建字符串表格值
     *
     * @param string $str 字符串
     * @return CData 表格值
     */
    public static function createValueStr(string $str): CData
    {
        return self::ffi()->uiNewTableValueString($str);
    }

    /**
     * 获取字符串表格值
     *
     * @param CData $v 表格值
     * @return string 字符串
     */
    public static function valueStr(CData $v): string
    {
        return self::ffi()->uiTableValueString($v);
    }

    /**
     * 创建图片表格值
     *
     * @param CData $img 图片
     * @return CData 表格值
     */
    public static function createValueImg(CData $img): CData
    {
        return self::ffi()->uiNewTableValueImage($img);
    }

    /**
     * 获取图片表格值
     *
     * @param CData $v 表格值
     * @return CData 图片
     */
    public static function valueImg(CData $v): CData
    {
        return self::ffi()->uiTableValueImage($v);
    }

    /**
     * 创建整数表格值
     *
     * @param int $i 整数
     * @return CData 表格值
     */
    public static function createValueInt(int $i): CData
    {
        return self::ffi()->uiNewTableValueInt($i);
    }

    /**
     * 获取整数表格值
     *
     * @param CData $v 表格值
     * @return int 整数
     */
    public static function valueInt(CData $v): int
    {
        return self::ffi()->uiTableValueInt($v);
    }

    /**
     * 创建颜色表格值
     *
     * @param float $r 红色
     * @param float $g 绿色
     * @param float $b 蓝色
     * @param float $a 透明度
     * @return CData 表格值
     */
    public static function createValueColor(float $r, float $g, float $b, float $a): CData
    {
        return self::ffi()->uiNewTableValueColor($r, $g, $b, $a);
    }

    /**
     * 获取颜色表格值
     *
     * @param CData $v 表格值
     * @return array 颜色
     */
    public static function valueColor(CData $v): array
    {
        $r = 0.0;
        $g = 0.0;
        $b = 0.0;
        $a = 0.0;
        self::ffi()->uiTableValueColor($v, $r, $g, $b, $a);
        return [
            $r,
            $g,
            $b,
            $a,
        ];
    }

    /**
     * 创建表格模型处理程序
     *
     * @return CData
     */
    public static function modelHandler(): CData
    {
        return self::ffi()->new("uiTableModelHandler");
    }

    /**
     * 创建表格模型
     *
     * @param CData $handler 表格模型处理程序
     * @return CData 表格模型
     */
    public static function createModel(CData $handler): CData
    {
        return self::ffi()->uiNewTableModel($handler);
    }

    /**
     * 表格模型行插入
     *
     * @param CData $model 表格模型
     * @param int $row 行索引
     * @return void
     */
    public static function modelRowInserted(CData $model, int $row): void
    {
        self::ffi()->uiTableModelRowInserted($model, $row);
    }

    /**
     * 表格模型行改变
     *
     * @param CData $model 表格模型
     * @param int $row 行索引
     * @return void
     */
    public static function modelRowChanged(CData $model, int $row): void
    {
        self::ffi()->uiTableModelRowChanged($model, $row);
    }

    /**
     * 表格模型行删除
     *
     * @param CData $model 表格模型
     * @param int $row 行索引
     * @return void
     */
    public static function modelRowDeleted(CData $model, int $row): void
    {
        self::ffi()->uiTableModelRowDeleted($model, $row);
    }

    /**
     * 表格模型列追加文本列
     *
     * @param CData $model 表格模型
     * @param string $name 列名称
     * @param int $textModelColumn 文本模型列
     * @param int $textEditableModelColumn 可编辑文本模型列
     * @param CData $textParams 文本列可选参数
     * @return void
     */
    public static function appendTextColumn(CData $model, string $name, int $textModelColumn, int $textEditableModelColumn, CData $textParams): void
    {
        self::ffi()->uiTableAppendTextColumn($model, $name, $textModelColumn, $textEditableModelColumn, $textParams);
    }

    /**
     * 表格模型列追加图片列
     *
     * @param CData $model 表格模型
     * @param string $name 列名称
     * @param int $imageModelColumn 图片模型列
     * @return void
     */
    public static function appendImageColumn(CData $model, string $name, int $imageModelColumn): void
    {
        self::ffi()->uiTableAppendImageColumn($model, $name, $imageModelColumn);
    }

    /**
     * 表格模型列追加图片文本列
     *
     * @param CData $model 表格模型
     * @param string $name 列名称
     * @param int $imageModelColumn 图片模型列
     * @param int $textModelColumn 文本模型列
     * @param int $textEditableModelColumn 可编辑文本模型列
     * @param CData $textParams 文本列可选参数
     * @return void
     */
    public static function appendImageTextColumn(CData $model, string $name, int $imageModelColumn, int $textModelColumn, int $textEditableModelColumn, CData $textParams): void
    {
        self::ffi()->uiTableAppendImageTextColumn($model, $name, $imageModelColumn, $textModelColumn, $textEditableModelColumn, $textParams);
    }

    /**
     * 表格模型列追加复选框列
     *
     * @param CData $model 表格模型
     * @param string $name 列名称
     * @param int $checkboxModelColumn 复选框模型列
     * @return void
     */
    public static function appendCheckboxColumn(CData $model, string $name, int $checkboxModelColumn): void
    {
        self::ffi()->uiTableAppendCheckboxColumn($model, $name, $checkboxModelColumn);
    }

    /**
     * 表格模型列追加复选框文本列
     *
     * @param CData $model 表格模型
     * @param string $name 列名称
     * @param int $checkboxModelColumn 复选框模型列
     * @param int $textModelColumn 文本模型列
     * @param int $textEditableModelColumn 可编辑文本模型列
     * @param CData $textParams 文本列可选参数
     * @return void
     */
    public static function appendCheckboxTextColumn(CData $model, string $name, int $checkboxModelColumn, int $textModelColumn, int $textEditableModelColumn, CData $textParams): void
    {
        self::ffi()->uiTableAppendCheckboxTextColumn($model, $name, $checkboxModelColumn, $textModelColumn, $textEditableModelColumn, $textParams);
    }

    /**
     * 表格模型列追加进度条列
     *
     * @param CData $model 表格模型
     * @param string $name 列名称
     * @param int $progressBarModelColumn 进度条模型列
     * @return void
     */
    public static function appendProgressBarColumn(CData $model, string $name, int $progressBarModelColumn): void
    {
        self::ffi()->uiTableAppendProgressBarColumn($model, $name, $progressBarModelColumn);
    }

    /**
     * 表格模型列追加按钮列
     *
     * @param CData $model 表格模型
     * @param string $name 列名称
     * @param int $buttonModelColumn 按钮模型列
     * @param int $buttonClickableModelColumn 按钮可点击模型列
     * @return void
     */
    public static function appendButtonColumn(CData $model, string $name, int $buttonModelColumn, int $buttonClickableModelColumn): void
    {
        self::ffi()->uiTableAppendButtonColumn($model, $name, $buttonModelColumn, $buttonClickableModelColumn);
    }

    /**
     * 表格头是否可见
     *
     * @param CData $t 表格句柄
     * @return bool 表格头是否可见
     */
    public static function headerVisible(CData $t): bool
    {
        return self::ffi()->uiTableHeaderVisible($t);
    }

    /**
     * 表格头设置可见
     *
     * @param CData $t 表格句柄
     * @param bool $visible 表格头是否可见
     * @return void
     */
    public static function headerSetVisible(CData $t, bool $visible): void
    {
        self::ffi()->uiTableHeaderSetVisible($t, $visible ? 1 : 0);
    }

    /**
     * 表格创建
     *
     * @param CData $params 表格参数
     * @return CData
     */
    public static function create(CData $params): CData
    {
        return self::ffi()->uiNewTable($params);
    }

    /**
     * 表格行点击事件
     *
     * @param CData $t 表格句柄
     * @param callable $callable 回调函数
     * @return void
     */
    public static function onRowClicked(CData $table, callable $callable): void
    {
        self::ffi()->uiTableOnRowClicked($table, function ($t, $row, $d) use ($callable, $table) {
            $callable($table, $row);
        }, null);
    }

    /**
     * 表格行双击事件
     *
     * @param CData $table 表格句柄
     * @param callable $callable 回调函数
     * @return void
     */
    public static function onRowDoubleClicked(CData $table, callable $callable): void
    {
        self::ffi()->uiTableOnRowDoubleClicked($table, function ($t, $row, $d) use ($callable, $table) {
            $callable($table, $row);
        }, null);
    }

    /**
     * 表格头设置排序指示器
     *
     * @param CData $table 表格句柄
     * @param int $column 列索引
     * @param SortIndicator $indicator 排序指示器
     * @return void
     */
    public static function headerSetSortIndicator(CData $table, int $column, SortIndicator $indicator): void
    {
        self::ffi()->uiTableHeaderSetSortIndicator($table, $column, $indicator->value);
    }

    /**
     * 表格头获取排序指示器
     *
     * @param CData $table 表格句柄
     * @param int $column 列索引
     * @return SortIndicator 排序指示器
     */
    public static function headerSortIndicator(CData $table, int $column): SortIndicator
    {
        return SortIndicator::from(self::ffi()->uiTableHeaderSortIndicator($table, $column));
    }

    /**
     * 表格头点击事件
     *
     * @param CData $table 表格句柄
     * @param callable $callable 回调函数
     * @return void
     */
    public static function headerOnClicked(CData $table, callable $callable): void
    {
        self::ffi()->uiTableHeaderOnClicked($table, function ($t, $column, $d) use ($callable, $table) {
            $callable($table, $column);
        }, null);
    }

    /**
     * 表格列宽度
     *
     * @param CData $table 表格句柄
     * @param int $column 列索引
     * @return int 列宽度
     */
    public static function columnWidth(CData $table, int $column): int
    {
        return self::ffi()->uiTableColumnWidth($table, $column);
    }

    /**
     * 表格列设置宽度
     *
     * @param CData $table 表格句柄
     * @param int $column 列索引
     * @param int $width 列宽度
     * @return void
     */
    public static function columnSetWidth(CData $table, int $column, int $width): void
    {
        self::ffi()->uiTableColumnSetWidth($table, $column, $width);
    }

    /**
     * 表格获取选择模式
     *
     * @param CData $table 表格句柄
     * @return TableSelectionMode 选择模式
     */
    public static function getSelectionMode(CData $table): TableSelectionMode
    {
        return TableSelectionMode::from(self::ffi()->uiTableGetSelectionMode($table));
    }

    /**
     * 表格设置选择模式
     *
     * @param CData $table 表格句柄
     * @param TableSelectionMode $mode 选择模式
     * @return void
     */
    public static function setSelectionMode(CData $table, TableSelectionMode $mode): void
    {
        self::ffi()->uiTableSetSelectionMode($table, $mode->value);
    }

    /**
     * 表格选择改变事件
     *
     * @param CData $table 表格句柄
     * @param callable $callable 回调函数
     * @return void
     */
    public static function onSelectionChanged(CData $table, callable $callable): void
    {
        self::ffi()->uiTableOnSelectionChanged($table, function ($t, $d) use ($callable, $table) {
            $callable($table);
        }, null);
    }

    /**
     * 表格获取选择
     *
     * @param CData $table 表格句柄
     * @return CData 选择句柄
     */
    public static function getSelection(CData $table): CData
    {
        return self::ffi()->uiTableGetSelection($table);
    }

    /**
     * 表格设置选择
     *
     * @param CData $table 表格句柄
     * @param CData $sel 选择句柄
     * @return void
     */
    public static function setSelection(CData $table, CData $sel): void
    {
        self::ffi()->uiTableSetSelection($table, $sel);
    }

    /**
     * 表格选择句柄释放
     *
     * @param CData $sel 选择句柄
     * @return void
     */
    public static function freeSelection(CData $sel): void
    {
        self::ffi()->uiFreeTableSelection($sel);
    }
}
