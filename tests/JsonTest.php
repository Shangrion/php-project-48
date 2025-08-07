<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;

use function Hexlet\Code\Formatters\Json\formatJson;

class JsonTest extends TestCase
{
    public function testFormatJson(): void
    {
        $diff = [
            ['key' => 'host', 'type' => 'unchanged', 'value' => 'hexlet.io'],
            ['key' => 'timeout', 'type' => 'changed', 'oldValue' => 50, 'newValue' => 20],
            ['key' => 'proxy', 'type' => 'removed', 'value' => '123.234.53.22'],
            ['key' => 'verbose', 'type' => 'added', 'value' => true],
        ];

        $expectedJson = <<<JSON
[
    {
        "key": "host",
        "type": "unchanged",
        "value": "hexlet.io"
    },
    {
        "key": "timeout",
        "type": "changed",
        "oldValue": 50,
        "newValue": 20
    },
    {
        "key": "proxy",
        "type": "removed",
        "value": "123.234.53.22"
    },
    {
        "key": "verbose",
        "type": "added",
        "value": true
    }
]
JSON;

        $this->assertSame($expectedJson, formatJson($diff));
    }
}
