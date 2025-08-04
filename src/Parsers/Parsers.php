<?php

namespace Hexlet\Code\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse($content, $format)
{
    return match ($format) {
        'json' => json_decode($content, true),
        'yml', 'yaml' => (array) Yaml::parse($content, Yaml::PARSE_OBJECT_FOR_MAP),
        default => throw new \Exception("Unsupported format: {$format}")
    };
}
