<?php namespace Votemike\Dbhelper;

class TableCollection
{
    public $tables = [];

    public function addColumnToTable($tableName, $columnName, $columnType, $dataType)
    {
        $column = new Column($columnName, $columnType, $dataType);
        $this->addToTable($tableName, $column);
    }

    private function addToTable($tableName, Column $column)
    {
        foreach ($this->tables as $table) {
            if ($table->name == $tableName) {
                $table->addColumn($column);
                return;
            }
        }

        $table = new Table($tableName);
        $table->addColumn($column);
        $this->tables[] = $table;
    }

    public function getTablesForDisplay()
    {
        $toDisplay = [];
        foreach ($this->tables as $table) {
            if ($table->shouldBeDisplayed()) {
                $toDisplay[] = $table;
            }
        }

        return $toDisplay;
    }

    public function populateTableColumnsWithLongestValue()
    {
        foreach ($this->tables as $table) {
            $table->populateColumnsWithLongestValue();
        }
    }

    public function populateTableNumericColumnsWithLowestValue()
    {
        foreach ($this->tables as $table) {
            $table->populateNumericColumnsWithLongestValue();
        }
    }

    public function populateTableColumnsWithSuggestedType()
    {
        foreach ($this->tables as $table) {
            $table->populateColumnsWithSuggestedType();
        }
    }
}