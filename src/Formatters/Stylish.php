<?php

namespace Hexlet\Code\Formatters;

function formatStylish(array $diff, int $depth = 1): string
{
    $indentSize = 4;
    $innerIndent = str_repeat(' ', $depth * $indentSize);
    $bracketIndent = str_repeat(' ', ($depth - 1) * $indentSize);

    $lines = [];

    foreach ($diff as $node) {
        $key = $node['key'];
        $type = $node['type'];

        switch ($type) {
            case 'added':
                $value = toString($node['value'], $depth + 1);
                $lines[] = str_repeat(' ', $depth * $indentSize - 2) . "+ {$key}: {$value}";
                break;

            case 'removed':
                $value = toString($node['value'], $depth + 1);
                $lines[] = str_repeat(' ', $depth * $indentSize - 2) . "- {$key}: {$value}";
                break;

            case 'unchanged':
                $value = toString($node['value'], $depth + 1);
                $lines[] = "{$innerIndent}{$key}: {$value}";
                break;

            case 'changed':
                $oldValue = toString($node['oldValue'], $depth + 1);
                $newValue = toString($node['newValue'], $depth + 1);
                $lines[] = str_repeat(' ', $depth * $indentSize - 2) . "- {$key}: {$oldValue}";
                $lines[] = str_repeat(' ', $depth * $indentSize - 2) . "+ {$key}: {$newValue}";
                break;

            case 'nested':
                $children = formatStylish($node['children'], $depth + 1);
                $lines[] = "{$innerIndent}{$key}: {$children}";
                break;

            default:
                throw new \Exception("Unknown node type: {$type}");
        }
    }

    return "{\n" . implode("\n", $lines) . "\n{$bracketIndent}}";
}

function toString(mixed $value, int $depth): string
{
    $indentSize = 4;

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if ($value === null) {
        return 'null';
    }

    if (!is_array($value)) {
        return (string)$value;
    }

    $lines = [];
    $currentIndent = str_repeat(' ', $depth * $indentSize);
    $closingIndent = str_repeat(' ', ($depth - 1) * $indentSize);

    foreach ($value as $key => $val) {
        $valStr = toString($val, $depth + 1);
        $lines[] = "{$currentIndent}{$key}: {$valStr}";
    }

    return "{\n" . implode("\n", $lines) . "\n{$closingIndent}}";
}
