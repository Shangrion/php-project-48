<?php

namespace Hexlet\Code\Formatters;

function formatStylish(array $diff, int $depth = 1): string
{
    $indentSize = 4;
    $bracketIndent = str_repeat(' ', ($depth - 1) * $indentSize);

    $lines = array_map(
        fn($node) => formatNode($node, $depth, $indentSize),
        $diff
    );

    return "{\n" . implode("\n", array_merge(...$lines)) . "\n{$bracketIndent}}";
}

function formatNode(array $node, int $depth, int $indentSize): array
{
    $innerIndent = str_repeat(' ', $depth * $indentSize);
    $key = $node['key'];
    $type = $node['type'];

    return match ($type) {
        'added' => [str_repeat(' ', $depth * $indentSize - 2) . "+ {$key}: " . toString($node['value'], $depth + 1)],
        'removed' => [str_repeat(' ', $depth * $indentSize - 2) . "- {$key}: " . toString($node['value'], $depth + 1)],
        'unchanged' => ["{$innerIndent}{$key}: " . toString($node['value'], $depth + 1)],
        'changed' => [
            str_repeat(' ', $depth * $indentSize - 2) . "- {$key}: " . toString($node['oldValue'], $depth + 1),
            str_repeat(' ', $depth * $indentSize - 2) . "+ {$key}: " . toString($node['newValue'], $depth + 1)
        ],
        'nested' => ["{$innerIndent}{$key}: " . formatStylish($node['children'], $depth + 1)],
        default => throw new \Exception("Unknown node type: {$type}"),
    };
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

    $currentIndent = str_repeat(' ', $depth * $indentSize);
    $closingIndent = str_repeat(' ', ($depth - 1) * $indentSize);

    $lines = array_map(
        fn($k, $v) => "{$currentIndent}{$k}: " . toString($v, $depth + 1),
        array_keys($value),
        array_values($value)
    );

    return "{\n" . implode("\n", $lines) . "\n{$closingIndent}}";
}
