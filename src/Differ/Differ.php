<?php

namespace Hexlet\Code;

use Funct\Collection;

use function Hexlet\Code\Parsers\parse;

function genDiff(string $path1, string $path2): string
{
    $format1 = pathinfo($path1, PATHINFO_EXTENSION);
    $format2 = pathinfo($path2, PATHINFO_EXTENSION);

    $content1 = file_get_contents($path1);
    $content2 = file_get_contents($path2);

    $data1 = parse($content1, $format1);
    $data2 = parse($content2, $format2);

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
