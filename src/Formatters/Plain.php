<?php

namespace Hexlet\Code\Formatters;

function formatPlain(array $diff): string
{
    return implode("\n", buildPlainOutput($diff));
}

function buildPlainOutput(array $diff, string $parentPath = ''): array
{
    return array_merge(...array_map(
        fn($node) => formatPlainNode($node, $parentPath),
        $diff
    ));
}

function formatPlainNode(array $node, string $parentPath): array
{
    $key = $node['key'];
    $type = $node['type'];
    $propertyPath = $parentPath === '' ? $key : "{$parentPath}.{$key}";

    return match ($type) {
        'added' => ["Property '{$propertyPath}' was added with value: " . formatValue($node['value'])],
        'removed' => ["Property '{$propertyPath}' was removed"],
        'changed' => ["Property '{$propertyPath}' was updated. From " . formatValue($node['oldValue']) . " to " . formatValue($node['newValue'])],
        'nested' => buildPlainOutput($node['children'], $propertyPath),
        'unchanged' => [],
        default => throw new \Exception("Unknown node type: {$type}"),
    };
}

function formatValue(mixed $value): string
{
    return match (true) {
        is_array($value) => '[complex value]',
        is_bool($value) => $value ? 'true' : 'false',
        $value === null => 'null',
        is_string($value) => "'{$value}'",
        default => (string) $value,
    };
}
