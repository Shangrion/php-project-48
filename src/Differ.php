<?php

namespace Differ\Differ;

use function Hexlet\Code\parseFile;
use function Hexlet\Code\Formatters\format;

function genDiff(string $pathToFile1, string $pathToFile2, string $formatName = 'stylish'): string
{
    $data1 = parseFile($pathToFile1);
    $data2 = parseFile($pathToFile2);

    $diff = buildDiff($data1, $data2);

    return format($diff, $formatName);
}

function buildDiff(array $data1, array $data2): array
{
    $allKeys = [...array_keys($data1), ...array_keys($data2)];
    $allKeys = array_values(array_unique($allKeys));
    $allKeysSorted = [...$allKeys];
    usort($allKeysSorted, fn($a, $b) => $a <=> $b);

    return array_map(
        fn(string $key) => buildDiffNode($key, $data1, $data2),
        $allKeysSorted
    );
}

function buildDiffNode(string $key, array $data1, array $data2): array
{
    $value1 = $data1[$key] ?? null;
    $value2 = $data2[$key] ?? null;

    $keyExistsInFirst = array_key_exists($key, $data1);
    $keyExistsInSecond = array_key_exists($key, $data2);

    return match (true) {
        !$keyExistsInFirst && $keyExistsInSecond => [
            'key' => $key,
            'type' => 'added',
            'value' => $value2,
        ],
        $keyExistsInFirst && !$keyExistsInSecond => [
            'key' => $key,
            'type' => 'removed',
            'value' => $value1,
        ],
        is_array($value1) && is_array($value2) => [
            'key' => $key,
            'type' => 'nested',
            'children' => buildDiff($value1, $value2),
        ],
        $value1 !== $value2 => [
            'key' => $key,
            'type' => 'changed',
            'oldValue' => $value1,
            'newValue' => $value2,
        ],
        default => [
            'key' => $key,
            'type' => 'unchanged',
            'value' => $value1,
        ],
    };
}
