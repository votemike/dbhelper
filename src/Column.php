<?php namespace Votemike\Dbhelper;

class Column
{
    /**
     * @var string
     */
    public $name = '';
    /**
     * @var string
     */
    public $type = '';
    /**
     * @var string
     */
    public $dataType = '';
    /**
     * Max value that is currently in DB
     *
     * @var
     */
    private $maxValue;
    /**
     * @var
     */
    private $suggestedType;

    /**
     * @param $name
     * @param $type
     * @param $dataType
     */
    public function __construct($name, $type, $dataType)
    {
        $this->name = $name;
        $this->type = $type;
        $this->dataType = $dataType;
    }

    /**
     * @return mixed
     */
    public function getSuggestedType()
    {
        return $this->suggestedType;
    }

    /**
     * @param float $threshold % of max possible value that code should switch to larger datatype
     */
    public function populateWithSuggestedType($threshold = 0.75)
    {
        if ($this->isNumeric()) {
            switch (true) {
                case ($this->maxValue <= (DataType::tinyInt() * $threshold)):
                    $this->suggestedType = 'tinyint';
                    break;
                case ($this->maxValue <= DataType::smallInt() * $threshold):
                    $this->suggestedType = 'smallint';
                    break;
                case ($this->maxValue <= DataType::mediumInt() * $threshold):
                    $this->suggestedType = 'mediumint';
                    break;
                case ($this->maxValue <= DataType::int() * $threshold):
                    $this->suggestedType = 'int';
                    break;
                default:
                    $this->suggestedType = 'bigint';
            }
        }
        if ($this->isTextual()) {
            switch (true) {
                case ($this->maxValue <= DataType::char() * $threshold && $this->dataType != 'varchar'): //char and varchar are unequal as they store info differently
                    $this->suggestedType = 'char';
                    break;
                case ($this->maxValue <= DataType::varChar() * $threshold):
                    $this->suggestedType = 'varchar';
                    break;
                case ($this->maxValue <= DataType::text() * $threshold): //This should never happen
                    $this->suggestedType = 'text';
                    break;
                case ($this->maxValue <= DataType::mediumText() * $threshold):
                    $this->suggestedType = 'mediumtext';
                    break;
                case ($this->maxValue <= DataType::longText() * $threshold):
                    $this->suggestedType = 'longtext';
                    break;
            }
        }
    }

    /**
     * @return bool
     */
    public function isNumeric()
    {
        return in_array($this->dataType, ['tinyint', 'smallint', 'mediumint', 'int', 'bigint']);
    }

    /**
     * @return bool
     */
    public function isTextual()
    {
        return in_array($this->dataType, ['char', 'varchar', 'text', 'mediumtext', 'longtext']);
    }

    /**
     * @param $value
     */
    public function setMaxValue($value)
    {
        $this->maxValue = $value;
    }

    /**
     * @return bool
     */
    public function shouldBeDisplayed()
    {
        if ($this->shouldBeIgnored()) {
            return false;
        }
        if ($this->dataType != $this->suggestedType) {
            return true;
        }
        return false;
    }

    /**
     * Some fields such as datetimes don't need to be displayed as they are only 1 size
     *
     * @return bool
     */
    private function shouldBeIgnored()
    {
        return in_array($this->dataType,
            ['blob', 'date', 'datetime', 'decimal', 'double', 'enum', 'time', 'timestamp']);
    }
}