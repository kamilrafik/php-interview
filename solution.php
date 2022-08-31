<?php

$input = [
    ['id' => 1, 'date' => '12.01.2020', 'name' => 'test1'],
    ['id' => 2, 'date' => '02.05.2020', 'name' => 'test2'],
    ['id' => 4, 'date' => '08.03.2020', 'name' => 'test4'],
    ['id' => 1, 'date' => '22.01.2020', 'name' => 'test1'],
    ['id' => 2, 'date' => '11.11.2020', 'name' => 'test4'],
    ['id' => 3, 'date' => '06.06.2020', 'name' => 'test3'],
];

// task #1
$ids = [];
print_r(array_filter($input, function ($value) use (&$ids) {
    $result = !in_array($value['id'], $ids);
    $ids[] = $value['id'];
    return $result;
}));
