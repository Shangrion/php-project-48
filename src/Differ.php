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
    $allKeys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
    sort($allKeys);

    $diff = [];

    foreach ($allKeys as $key) {
        $value1 = array_key_exists($key, $data1) ? $data1[$key] : null;
        $value2 = array_key_exists($key, $data2) ? $data2[$key] : null;

        $keyExistsInFirst = array_key_exists($key, $data1);
        $keyExistsInSecond = array_key_exists($key, $data2);

        if (!$keyExistsInFirst && $keyExistsInSecond) {
            $diff[] = [
                'key' => $key,
                'type' => 'added',
                'value' => $value2
            ];
        } elseif ($keyExistsInFirst && !$keyExistsInSecond) {
            $diff[] = [
                'key' => $key,
                'type' => 'removed',
                'value' => $value1
            ];
        } elseif (is_array($value1) && is_array($value2)) {
            $diff[] = [
                'key' => $key,
                'type' => 'nested',
                'children' => buildDiff($value1, $value2)
            ];
        } elseif ($value1 !== $value2) {
            $diff[] = [
                'key' => $key,
                'type' => 'changed',
                'oldValue' => $value1,
                'newValue' => $value2
            ];
        } else {
            $diff[] = [
                'key' => $key,
                'type' => 'unchanged',
                'value' => $value1
            ];
        }
    }

    return $diff;
}
