<?php

namespace Hexlet\Code;

use Symfony\Component\Yaml\Yaml;

function parseFile(string $path): array
{
    $extension = pathinfo($path, PATHINFO_EXTENSION);

    if (in_array($extension, ['yml', 'yaml'])) {
        $parsed = Yaml::parseFile($path);
        if (!is_array($parsed)) {
            return [];
        }
        return $parsed;
    }

    if ($extension === 'json') {
        $content = file_get_contents($path);
        $parsed = json_decode($content, true);
        if (!is_array($parsed)) {
            return [];
        }
        return $parsed;
    }

    throw new \Exception("Unsupported file extension: {$extension}");
}
