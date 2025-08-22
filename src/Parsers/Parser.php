<?php

namespace Hexlet\Code\Parsers;

use Symfony\Component\Yaml\Yaml;

function parseFile(string $path): array
{
    $content = file_get_contents($path);

    if ($content === false) {
        throw new \Exception("Cannot read file: {$path}");
    }

    $extension = pathinfo($path, PATHINFO_EXTENSION);

    return match ($extension) {
        'json' => parseJson($content),
        'yml', 'yaml' => parseYaml($content),
        default => throw new \Exception("Unsupported file format: {$extension}"),
    };
}

function parseJson(string $json): array
{
    $data = json_decode($json, true);

    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        throw new \Exception("JSON decode error: " . json_last_error_msg());
    }

    return $data;
}

function parseYaml(string $yaml): array
{
    return Yaml::parse($yaml);
}
