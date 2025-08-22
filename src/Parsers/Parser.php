<?php

namespace Hexlet\Code;

use Symfony\Component\Yaml\Yaml;

function parseFile(string $path): array
{
    $extension = pathinfo($path, PATHINFO_EXTENSION);

    return match ($extension) {
        'yml', 'yaml' => Yaml::parseFile($path) ?: [],
        'json' => json_decode(file_get_contents($path) ?: '', true, 512, JSON_THROW_ON_ERROR),
        default => throw new \Exception("Unsupported file extension: {$extension}"),
    };
}
