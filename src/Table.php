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
     * @param CData|null $v 表格值
     * @return TableValueType 表格值类型
     */
    public static function getValueType(CData|null $v): TableValueType
    {
        if (!isset($v) || $v == null) {
            return TableValueType::Null;
        }
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
     * @param int $NumColumns 列数
     * @param TableValueType $ColumnType 列类型
     * @param int $NumRows 行数
     * @param callable:CData $CellValue 单元格值回调
     * @param callable|null $SetCellValue 单元格值设置回调
     * 
     * @return CData 表格模型处理程序
     */
    public static function modelHandler(
        int $NumColumns,
        TableValueType $ColumnType,
        int $NumRows,
        callable $CellValue,
        callable|null $SetCellValue = null
    ): CData {
        $handler = self::ffi()->new("uiTableModelHandler");
        $handler->NumColumns = function ($h, $m) use ($NumColumns) {
            return $NumColumns;
        };
        $handler->ColumnType = function ($h, $m, $i) use ($ColumnType) {
            return $ColumnType->value;
        };
        $handler->NumRows = function ($h, $m) use ($NumRows) {
            return $NumRows;
        };
        $handler->CellValue = function ($h, $m, $row, $column) use ($handler, $CellValue) {
            return $CellValue($handler, $row, $column);
        };
        $handler->SetCellValue = function ($h, $m, $row, $column, $v) use ($handler, $SetCellValue) {
            $SetCellValue($handler, $row, $column, $v);
        };
        return $handler;
    }

    /**
     * 创建表格模型
     *
     * @param CData $handler 表格模型处理程序
     * @return CData 表格模型
     */
    public static function createModel(CData $handler): CData
    {
        $c_handler = self::ffi()->cast("uiTableModelHandler [1]", $handler);
        return self::ffi()->uiNewTableModel($c_handler);
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
     * @param int $textParams 文本列可选参数
     * @return void
     */
    public static function appendTextColumn(
        CData $model,
        string $name,
        int $textModelColumn,
        int $textEditableModelColumn,
        int $textParams = -1
    ): void {
        $c_textParamsStruct = self::ffi()->new("uiTableTextColumnOptionalParams");
        $c_textParamsStruct->ColorModelColumn = $textParams;
        $c_textParams = self::ffi()->cast("uiTableTextColumnOptionalParams [1]", $c_textParamsStruct);
        self::ffi()->uiTableAppendTextColumn(
            $model,
            $name,
            $textModelColumn,
            $textEditableModelColumn,
            $c_textParams
        );
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
     * @param int $textParams 文本列可选参数
     * @return void
     */
    public static function appendImageTextColumn(CData $model, string $name, int $imageModelColumn, int $textModelColumn, int $textEditableModelColumn, int $textParams = -1): void
    {
        $c_textParamsStruct = self::ffi()->new("uiTableTextColumnOptionalParams");
        $c_textParamsStruct->ColorModelColumn = $textParams;
        $c_textParams = self::ffi()->cast("uiTableTextColumnOptionalParams [1]", $c_textParamsStruct);
        self::ffi()->uiTableAppendImageTextColumn($model, $name, $imageModelColumn, $textModelColumn, $textEditableModelColumn, $c_textParams);
    }

    /**
     * 表格模型列追加复选框列
     *
     * @param CData $model 表格模型
     * @param string $name 列名称
     * @param int $checkboxModelColumn 复选框模型列
     * @return void
     */
    public static function appendCheckboxColumn(
        CData $model,
        string $name,
        int $checkboxModelColumn,
        int $checkboxEditableModelColumn = -1
    ): void {
        self::ffi()->uiTableAppendCheckboxColumn(
            $model,
            $name,
            $checkboxModelColumn,
            $checkboxEditableModelColumn
        );
    }

    /**
     * 表格模型列追加复选框文本列
     *
     * @param CData $model 表格模型
     * @param string $name 列名称
     * @param int $checkboxModelColumn 复选框模型列
     * @param int $textModelColumn 文本模型列
     * @param int $textEditableModelColumn 可编辑文本模型列
     * @param int $textParams 文本列可选参数
     * @return void
     */
    public static function appendCheckboxTextColumn(CData $model, string $name, int $checkboxModelColumn, int $textModelColumn, int $textEditableModelColumn, int $textParams = -1): void
    {
        $c_textParamsStruct = self::ffi()->new("uiTableTextColumnOptionalParams");
        $c_textParamsStruct->ColorModelColumn = $textParams;
        $c_textParams = self::ffi()->cast("uiTableTextColumnOptionalParams [1]", $c_textParamsStruct);
        self::ffi()->uiTableAppendCheckboxTextColumn($model, $name, $checkboxModelColumn, $textModelColumn, $textEditableModelColumn, $c_textParams);
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
    public static function appendButtonColumn(
        CData $model,
        string $name,
        int $buttonModelColumn,
        int $buttonClickableModelColumn
    ): void {
        self::ffi()->uiTableAppendButtonColumn($model, $name, $buttonModelColumn, $buttonClickableModelColumn);
    }

    /**
     * 表格创建
     *
     * @param CData $model 表格模型
     * @param int $RowBackgroundColorModelColumn 行背景颜色模型列
     * @return CData
     */
    public static function create(
        CData $model,
        int $RowBackgroundColorModelColumn
    ): CData {
        $params =  self::ffi()->new("uiTableParams");
        $params->Model = $model;
        $params->RowBackgroundColorModelColumn = $RowBackgroundColorModelColumn;
        $c_params = self::ffi()->cast("uiTableParams[1]", $params);
        return self::ffi()->uiNewTable($c_params);
    }
}
