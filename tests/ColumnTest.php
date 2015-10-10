<?php

use Votemike\Dbhelper\Column;

class ColumnTest extends TestCase
{

    public function testIfColumnShouldBeDisplayed()
    {
        $column = $this->generateNumericColumn(255, 1);
        $this->assertFalse($column->shouldBeDisplayed());
    }

    private function generateNumericColumn($maxValue, $threshold = 0.75)
    {
        $column = new Column('test', 'test',
            'tinyint'); //in this test, datatype only serves to say if the column is numeric or not
        $column->setMaxValue($maxValue);
        $column->populateWithSuggestedType($threshold);

        return $column;
    }

    public function testNumericSuggestedType()
    {
        $column = $this->generateNumericColumn(255, 1);
        $this->assertEquals('tinyint', $column->getSuggestedType());
        $column = $this->generateNumericColumn(65535, 1);
        $this->assertEquals('smallint', $column->getSuggestedType());
        $column = $this->generateNumericColumn(16777215, 1);
        $this->assertEquals('mediumint', $column->getSuggestedType());
        $column = $this->generateNumericColumn(4294967295, 1);
        $this->assertEquals('int', $column->getSuggestedType());
        $column = $this->generateNumericColumn(18446744073709551615, 1);
        $this->assertEquals('bigint', $column->getSuggestedType());

        $column = $this->generateNumericColumn(255);
        $this->assertEquals('smallint', $column->getSuggestedType());
        $column = $this->generateNumericColumn(65535);
        $this->assertEquals('mediumint', $column->getSuggestedType());
        $column = $this->generateNumericColumn(16777215);
        $this->assertEquals('int', $column->getSuggestedType());
        $column = $this->generateNumericColumn(4294967295);
        $this->assertEquals('bigint', $column->getSuggestedType());
    }

    public function testTextualSuggestedType()
    {
        $column = $this->generateTextualColumn(255, 1);
        $this->assertEquals('char', $column->getSuggestedType());
        $column = $this->generateTextualColumn(65535, 1);
        $this->assertEquals('varchar', $column->getSuggestedType());
        $column = $this->generateTextualColumn(16777215, 1);
        $this->assertEquals('mediumtext', $column->getSuggestedType());
        $column = $this->generateTextualColumn(4294967295, 1);
        $this->assertEquals('longtext', $column->getSuggestedType());

        $column = $this->generateTextualColumn(255);
        $this->assertEquals('varchar', $column->getSuggestedType());
        $column = $this->generateTextualColumn(65535);
        $this->assertEquals('mediumtext', $column->getSuggestedType());
        $column = $this->generateTextualColumn(16777215);
        $this->assertEquals('longtext', $column->getSuggestedType());
    }

    private function generateTextualColumn($maxValue, $threshold = 0.75)
    {
        $column = new Column('test', 'test',
            'char'); //in this test, datatype only serves to say if the column is textual or not
        $column->setMaxValue($maxValue);
        $column->populateWithSuggestedType($threshold);

        return $column;
    }
}