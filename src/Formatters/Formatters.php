<?php

namespace Hexlet\Code\Formatters;

use function Hexlet\Code\Formatters\Json\formatJson;

function format(array $diff, string $formatName): string
{
    return match ($formatName) {
        'stylish' => formatStylish($diff),
        'plain' => formatPlain($diff),
        'json' => formatJson($diff),
        default => throw new \Exception("Unknown format: {$formatName}")
    };
}
