<?php namespace Votemike\Dbhelper;

class DataType
{
    public static function tinyInt()
    {
        return self::maxLengthFromBytes(1);
    }

    public static function smallInt()
    {
        return self::maxLengthFromBytes(2);
    }

    public static function mediumInt()
    {
        return self::maxLengthFromBytes(3);
    }

    public static function int()
    {
        return self::maxLengthFromBytes(4);
    }

    public static function bigInt()
    {
        return self::maxLengthFromBytes(8);
    }

    public static function signedTinyInt()
    {
        return self::signedMaxLengthFromBytes(1);
    }

    public static function signedSmallInt()
    {
        return self::signedMaxLengthFromBytes(2);
    }

    public static function signedMediumInt()
    {
        return self::signedMaxLengthFromBytes(3);
    }

    public static function signedInt()
    {
        return self::signedMaxLengthFromBytes(4);
    }

    public static function signedBigInt()
    {
        return self::signedMaxLengthFromBytes(8);
    }

    public static function char()
    {
        return self::maxLengthFromBytes(1);
    }

    public static function varChar()
    {
        return self::maxLengthFromBytes(2);
    }

    public static function text()
    {
        return self::maxLengthFromBytes(2);
    }

    public static function mediumText()
    {
        return self::maxLengthFromBytes(3);
    }

    public static function longText()
    {
        return self::maxLengthFromBytes(4);
    }

    /**
     * Returns the size of a field from the number of bytes it has
     * 2^($bytes*8)-1
     *
     * @param $bytes
     * @return int
     */
    private static function maxLengthFromBytes($bytes)
    {
        return pow(2, $bytes * 8) - 1;
    }

    /**
     * Returns the size of a field from the number of bytes it has
     * 2^(($bytes*8)-1)
     *
     * @param $bytes
     * @return int
     */
    private static function signedMaxLengthFromBytes($bytes)
    {
        return pow(2, ($bytes * 8) - 1);
    }
}