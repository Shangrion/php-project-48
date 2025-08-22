<?php

namespace Hexlet\Code;

use Symfony\Component\Yaml\Yaml;

function parseFile(string $path): array
{
    $extension = pathinfo($path, PATHINFO_EXTENSION);

    if (in_array($extension, ['yml', 'yaml'], true)) {
        $parsed = Yaml::parseFile($path);
        return is_array($parsed) ? $parsed : [];
    }

    if ($extension === 'json') {
        $content = file_get_contents($path);
        $parsed = json_decode($content, true);
        return is_array($parsed) ? $parsed : [];
    }

    throw new \Exception("Unsupported file extension: {$extension}");
}
