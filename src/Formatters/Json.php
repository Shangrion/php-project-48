<?php

namespace Hexlet\Code\Formatters\Json;

function formatJson(array $diff): string
{
    return json_encode($diff, JSON_PRETTY_PRINT);
}
