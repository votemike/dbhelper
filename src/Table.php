<?php

namespace Votemike\Dbhelper;

use DB;

class Table
{
    public $name = '';
    private $columns = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function addColumn(Column $column)
    {
        $this->columns[] = $column;
    }

    public function getColumns()
    {
        return $this->columns;
    }

    public function getColumnsForDisplay()
    {
        $toDisplay = [];
        foreach ($this->columns as $column) {
            if ($column->shouldBeDisplayed()) {
                $toDisplay[] = $column;
            }
        }

        return $toDisplay;
    }

    /**
     * Go through each column and find the largest value of that field
     */
    public function populateColumnsWithLongestValue()
    {
        $query = DB::table($this->name);
        foreach ($this->columns as $column) {
            if ($column->isNumeric()) {
                $query->addSelect(DB::raw('MAX(`' . $column->name . '`) as `' . $column->name . '`'));
            }
            if ($column->isTextual()) {
                $query->addSelect(DB::raw('MAX(LENGTH(`' . $column->name . '`)) as `' . $column->name . '`'));
            }
        }
        $result = $query->first();
        foreach ($this->columns as $column) {
            $columnName = $column->name;
            if (isset($result->$columnName)) {
                $column->setMaxValue($result->$columnName);
            }
        }
    }

    public function populateColumnsWithSuggestedType($threshold = 0.75)
    {
        foreach ($this->columns as $column) {
            $column->populateWithSuggestedType($threshold);
        }
    }

    /**
     * Go through each column and find the lowest value of that field
     */
    public function populateNumericColumnsWithLongestValue()
    {
        $query = DB::table($this->name);
        foreach ($this->columns as $column) {
            if ($column->isNumeric()) {
                $query->addSelect(DB::raw('MIN(`' . $column->name . '`) as `' . $column->name . '`'));
            }
        }
        $result = $query->first();
        foreach ($this->columns as $column) {
            $columnName = $column->name;
            if (isset($result->$columnName)) {
                $column->setMinValue($result->$columnName);
            }
        }
    }

    /**
     * If no columns from the table need to be displayed, the table doesn't need to be displayed
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        foreach ($this->columns as $column) {
            if ($column->shouldBeDisplayed()) {
                return true;
            }
        }

        return false;
    }
}