<?php

namespace Hexlet\Code\Formatters;

function formatPlain(array $diff): string
{
    $lines = buildPlainOutput($diff);
    return implode("\n", $lines);
}

function buildPlainOutput(array $diff, string $parentPath = ''): array
{
    $lines = [];

    foreach ($diff as $node) {
        $key = $node['key'];
        $type = $node['type'];
        $propertyPath = $parentPath === '' ? $key : "{$parentPath}.{$key}";

        switch ($type) {
            case 'added':
                $value = formatValue($node['value']);
                $lines[] = "Property '{$propertyPath}' was added with value: {$value}";
                break;

            case 'removed':
                $lines[] = "Property '{$propertyPath}' was removed";
                break;

            case 'changed':
                $oldValue = formatValue($node['oldValue']);
                $newValue = formatValue($node['newValue']);
                $lines[] = "Property '{$propertyPath}' was updated. From {$oldValue} to {$newValue}";
                break;

            case 'nested':
                $lines = array_merge($lines, buildPlainOutput($node['children'], $propertyPath));
                break;

            case 'unchanged':
                break;

            default:
                throw new \Exception("Unknown node type: {$type}");
        }
    }

    return $lines;
}

function formatValue(mixed $value): string
{
    if (is_array($value)) {
        return '[complex value]';
    }

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if ($value === null) {
        return 'null';
    }

    if (is_string($value)) {
        return "'{$value}'";
    }

    return (string) $value;
}
