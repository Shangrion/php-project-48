<?php

namespace Hexlet\Code;

use Funct\Collection;

function genDiff(string $path1, string $path2): string
{
    $data1 = json_decode(file_get_contents($path1), true);
    $data2 = json_decode(file_get_contents($path2), true);

    $keys1 = array_keys($data1);
    $keys2 = array_keys($data2);
    $allKeys = Collection\union($keys1, $keys2);
    $sortedKeys = Collection\sortBy($allKeys, fn($key) => $key);

    $lines = [];
    foreach ($sortedKeys as $key) {
        $inFirst = array_key_exists($key, $data1);
        $inSecond = array_key_exists($key, $data2);

        if ($inFirst && !$inSecond) {
            $lines[] = "  - {$key}: " . renderValue($data1[$key]);
        } elseif (!$inFirst && $inSecond) {
            $lines[] = "  + {$key}: " . renderValue($data2[$key]);
        } elseif ($inFirst && $inSecond && $data1[$key] !== $data2[$key]) {
            $lines[] = "  - {$key}: " . renderValue($data1[$key]);
            $lines[] = "  + {$key}: " . renderValue($data2[$key]);
        } else {
            $lines[] = "    {$key}: " . renderValue($data1[$key]);
        }
    }

    return "{\n" . implode("\n", $lines) . "\n}";
}

function renderValue($value): string
{
    return match (true) {
        $value === true => 'true',
        $value === false => 'false',
        $value === null => 'null',
        default => (string) $value,
    };
}
