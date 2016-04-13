<?php

use Votemike\Dbhelper\Column;

class ColumnTest extends TestCase
{

    public function testIfColumnShouldBeDisplayed()
    {
        $column = $this->generateNumericColumn(255, 0, 1);
        $this->assertFalse($column->shouldBeDisplayed());
    }

    private function generateNumericColumn($maxValue, $minValue = 0, $threshold = 0.75)
    {
        //in this test, datatype only serves to say if the column is numeric or not
        $column = new Column('test', 'test', 'tinyint');
        $column->setMaxValue($maxValue);
        $column->setMinValue($minValue);
        $column->populateWithSuggestedType($threshold);

        return $column;
    }

    public function testNumericSuggestedType()
    {
        $column = $this->generateNumericColumn(255, 0, 1);
        $this->assertEquals('tinyint', $column->getSuggestedType());
        $this->assertTrue($column->shouldBeUnsigned());
        $column = $this->generateNumericColumn(65535, 0, 1);
        $this->assertEquals('smallint', $column->getSuggestedType());
        $this->assertTrue($column->shouldBeUnsigned());
        $column = $this->generateNumericColumn(16777215, 0, 1);
        $this->assertEquals('mediumint', $column->getSuggestedType());
        $this->assertTrue($column->shouldBeUnsigned());
        $column = $this->generateNumericColumn(4294967295, 0, 1);
        $this->assertEquals('int', $column->getSuggestedType());
        $this->assertTrue($column->shouldBeUnsigned());
        $column = $this->generateNumericColumn(18446744073709551615, 0, 1);
        $this->assertEquals('bigint', $column->getSuggestedType());
        $this->assertTrue($column->shouldBeUnsigned());

        $column = $this->generateNumericColumn(255);
        $this->assertEquals('smallint', $column->getSuggestedType());
        $this->assertTrue($column->shouldBeUnsigned());
        $column = $this->generateNumericColumn(65535);
        $this->assertEquals('mediumint', $column->getSuggestedType());
        $this->assertTrue($column->shouldBeUnsigned());
        $column = $this->generateNumericColumn(16777215);
        $this->assertEquals('int', $column->getSuggestedType());
        $this->assertTrue($column->shouldBeUnsigned());
        $column = $this->generateNumericColumn(4294967295);
        $this->assertEquals('bigint', $column->getSuggestedType());
        $this->assertTrue($column->shouldBeUnsigned());

        $column = $this->generateNumericColumn(128, -1, 1);
        $this->assertEquals('tinyint', $column->getSuggestedType());
        $this->assertFalse($column->shouldBeUnsigned());
        $column = $this->generateNumericColumn(32768, -1, 1);
        $this->assertEquals('smallint', $column->getSuggestedType());
        $this->assertFalse($column->shouldBeUnsigned());
        $column = $this->generateNumericColumn(8388608, -1, 1);
        $this->assertEquals('mediumint', $column->getSuggestedType());
        $this->assertFalse($column->shouldBeUnsigned());
        $column = $this->generateNumericColumn(2147483648, -1, 1);
        $this->assertEquals('int', $column->getSuggestedType());
        $this->assertFalse($column->shouldBeUnsigned());
        $column = $this->generateNumericColumn(9223372036854775807, -1, 1);
        $this->assertEquals('bigint', $column->getSuggestedType());
        $this->assertFalse($column->shouldBeUnsigned());

        $column = $this->generateNumericColumn(128, 0, 1);
        $this->assertEquals('tinyint', $column->getSuggestedType());
        $this->assertTrue($column->shouldBeUnsigned());
        $column = $this->generateNumericColumn(32768, 0, 1);
        $this->assertEquals('smallint', $column->getSuggestedType());
        $this->assertTrue($column->shouldBeUnsigned());
        $column = $this->generateNumericColumn(8388608, 0, 1);
        $this->assertEquals('mediumint', $column->getSuggestedType());
        $this->assertTrue($column->shouldBeUnsigned());
        $column = $this->generateNumericColumn(2147483648, 0, 1);
        $this->assertEquals('int', $column->getSuggestedType());
        $this->assertTrue($column->shouldBeUnsigned());
        $column = $this->generateNumericColumn(9223372036854775808, 0, 1);
        $this->assertEquals('bigint', $column->getSuggestedType());
        $this->assertTrue($column->shouldBeUnsigned());

        $column = $this->generateNumericColumn(128, -1);
        $this->assertEquals('smallint', $column->getSuggestedType());
        $this->assertFalse($column->shouldBeUnsigned());
        $column = $this->generateNumericColumn(32768, -1);
        $this->assertEquals('mediumint', $column->getSuggestedType());
        $this->assertFalse($column->shouldBeUnsigned());
        $column = $this->generateNumericColumn(8388608, -1);
        $this->assertEquals('int', $column->getSuggestedType());
        $this->assertFalse($column->shouldBeUnsigned());
        $column = $this->generateNumericColumn(2147483648, -1);
        $this->assertEquals('bigint', $column->getSuggestedType());
        $this->assertFalse($column->shouldBeUnsigned());

        $column = $this->generateNumericColumn(0, -127);
        $this->assertEquals('smallint', $column->getSuggestedType());
        $this->assertFalse($column->shouldBeUnsigned());
        $column = $this->generateNumericColumn(0, -32767);
        $this->assertEquals('mediumint', $column->getSuggestedType());
        $this->assertFalse($column->shouldBeUnsigned());
        $column = $this->generateNumericColumn(0, -8388607);
        $this->assertEquals('int', $column->getSuggestedType());
        $this->assertFalse($column->shouldBeUnsigned());
        $column = $this->generateNumericColumn(0, -2147483647);
        $this->assertEquals('bigint', $column->getSuggestedType());
        $this->assertFalse($column->shouldBeUnsigned());
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