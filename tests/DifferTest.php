<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;

use function Hexlet\Code\genDiff;

class DifferTest extends TestCase
{
    private string $fixturePath1;
    private string $fixturePath2;

    protected function setUp(): void
    {
        $this->fixturePath1 = __DIR__ . '/fixtures/file1.json';
        $this->fixturePath2 = __DIR__ . '/fixtures/file2.json';
    }

    public function testGenDiff(): void
    {
        $expected = <<<EXPECTED
{
  - follow: false
    host: hexlet.io
  - proxy: 123.234.53.22
  - timeout: 50
  + timeout: 20
  + verbose: true
}
EXPECTED;

        $actual = genDiff($this->fixturePath1, $this->fixturePath2);
        $this->assertEquals($expected, $actual);
    }
}
