<?php

namespace Hexlet\Code;

use Funct\Collection;

function genDiff($path1, $path2)
{
    $data1 = json_decode(file_get_contents($path1), true);
    $data2 = json_decode(file_get_contents($path2), true);

    $keys1 = array_keys($data1);
    $keys2 = array_keys($data2);
    $allKeys = Collection\union($keys1, $keys2);
    $sortedKeys = Collection\sortBy($allKeys, function ($key) { return $key; });

    $lines = [];
    foreach ($sortedKeys as $key) {
        if (array_key_exists($key, $data1) && !array_key_exists($key, $data2)) {
            $lines[] = "  - {$key}: " . renderValue($data1[$key]);
        } elseif (!array_key_exists($key, $data1) && array_key_exists($key, $data2)) {
            $lines[] = "  + {$key}: " . renderValue($data2[$key]);
        } elseif ($data1[$key] !== $data2[$key]) {
            $lines[] = "  - {$key}: " . renderValue($data1[$key]);
            $lines[] = "  + {$key}: " . renderValue($data2[$key]);
        } else {
            $lines[] = "    {$key}: " . renderValue($data1[$key]);
        }
    }

    return "{\n" . implode("\n", $lines) . "\n}";
}

function renderValue($value)
{
    if ($value === true) {
        return 'true';
    }
    if ($value === false) {
        return 'false';
    }
    if ($value === null) {
        return 'null';
    }
    return $value;
}