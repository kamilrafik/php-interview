<?php

$input = [
    ['id' => 1, 'date' => '12.01.2020', 'name' => 'test1'],
    ['id' => 2, 'date' => '02.05.2020', 'name' => 'test2'],
    ['id' => 4, 'date' => '08.03.2020', 'name' => 'test4'],
    ['id' => 1, 'date' => '22.01.2020', 'name' => 'test1'],
    ['id' => 2, 'date' => '11.11.2020', 'name' => 'test4'],
    ['id' => 3, 'date' => '06.06.2020', 'name' => 'test3'],
];

////////////////////////////////////////////
// task #1

$ids = [];
print_r(array_filter($input, function ($value) use (&$ids) {
    $result = !in_array($value['id'], $ids);
    $ids[] = $value['id'];
    return $result;
}));

////////////////////////////////////////////
// task #2

class Sorter
{
    protected static $key;

    public static function sort(&$array, $key)
    {
        if (!count($array)) {
            return;
        }

        $method = null;
        if (is_integer($array[0][$key])) {
            $method = 'sortIntegers';
        } elseif (preg_match('/^([0-9]{2})\.([0-9]{2})\.([0-9]{4})$/', $array[0][$key])) {
            $method = 'sortDates';
        } else {
            $method = 'sortStrings';
        }

        self::$key = $key;
        usort($array, [Sorter::class, $method]);
    }

    protected static function sortIntegerValues($a, $b)
    {
        if ($a === $b) {
            return 0;
        } else {
            return $a < $b ? -1 : 1;
        }
    }

    protected static function sortIntegers($a, $b)
    {
        return self::sortIntegerValues($a[self::$key], $b[self::$key]);
    }

    protected static function sortDates($a, $b)
    {
        return self::sortIntegerValues(strtotime($a[self::$key]), strtotime($b[self::$key]));
    }

    protected static function sortStrings($a, $b)
    {
        return strcmp($a[self::$key], $b[self::$key]);
    }
}

Sorter::sort($input, 'id');
print_r($input);
Sorter::sort($input, 'date');
print_r($input);
Sorter::sort($input, 'name');
print_r($input);

////////////////////////////////////////////
// task #3

class Query
{
    protected static $key;

    protected static $operators = [
        '===' => '===',
        '<' => '<',
        '>' => '>',
    ];

    public static function get($array, $key, $comparedValue, $operator)
    {
        if (
            !count($array)
            || !preg_match('/^([a-z]+)$/i', $key)
            || !preg_match('/^([a-z0-9.]+)$/i', $comparedValue)
            || !isset(self::$operators[$operator])
        ) {
            return [];
        }

        $method = null;
        if (is_integer($array[0][$key])) {
            $method = 'compareIntegers';
        } elseif (preg_match('/^([0-9]{2})\.([0-9]{2})\.([0-9]{4})$/', $array[0][$key])) {
            $method = 'compareDates';
        } else {
            $method = 'compareStrings';
        }

        return array_filter($array, function ($value) use (
            $method,
            $key,
            $comparedValue,
            $operator
        ) {
            return self::$method($value[$key], $comparedValue, self::$operators[$operator]);
        });
    }

    protected static function compareIntegerValue($a, $b, $operator)
    {
        return eval('return ' . $a . ' ' . $operator . ' ' . $b . ';');
    }

    protected static function compareIntegers($value, $comparedValue, $operator)
    {
        return self::compareIntegerValue($value, $comparedValue, $operator);
    }

    protected static function compareDates($value, $comparedValue, $operator)
    {
        return self::compareIntegerValue(strtotime($value), strtotime($comparedValue), $operator);
    }

    protected static function compareStrings($value, $comparedValue, $operator)
    {
        if ($operator === '===') {
            return eval('return ($value === $comparedValue);');
        } else {
            $n = $operator === '>' ? '1' : '-1';
            return eval('return strcmp($value, $comparedValue) === ' . $n . ';');
        }
    }
}

print_r(Query::get($input, 'id', 2, '>'));
print_r(Query::get($input, 'name', 'test3', '==='));
print_r(Query::get($input, 'date', '13.01.2020', '<'));
print_r(Query::get($input, 'name', 'test3', '>'));