<?php

namespace Differ\Differ;

use function Hexlet\Code\Parsers\parseFile;
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
    $allKeys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
    $sortedKeys = sortKeysFunctional($allKeys);

    return array_map(
        fn(string $key) => buildDiffNode($key, $data1, $data2),
        $sortedKeys
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

function sortKeysFunctional(array $keys): array
{
    $result = [];
    foreach ($keys as $key) {
        $before = array_filter($result, fn($k) => $k < $key);
        $after = array_filter($result, fn($k) => $k >= $key);
        $result = array_merge($before, [$key], $after);
    }
    return $result;
}
