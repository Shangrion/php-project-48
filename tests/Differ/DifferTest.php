<?php

namespace Hexlet\Code\Tests\Differ;

use PHPUnit\Framework\TestCase;

use function Hexlet\Code\genDiff;

class DifferTest extends TestCase
{
    private string $fixturesPath;

    protected function setUp(): void
    {
        $this->fixturesPath = __DIR__ . '/../fixtures';
    }

    public function testGenDiffJson(): void
    {
        $file1 = $this->fixturesPath . '/file1.json';
        $file2 = $this->fixturesPath . '/file2.json';

        $expected = <<<TEXT
{
  - follow: false
    host: hexlet.io
  - proxy: 123.234.53.22
  - timeout: 50
  + timeout: 20
  + verbose: true
}
TEXT;

        $actual = genDiff($file1, $file2);
        $this->assertEquals(trim($expected), trim($actual));
    }

    public function testGenDiffYaml(): void
    {
        $file1 = $this->fixturesPath . '/file1.yml';
        $file2 = $this->fixturesPath . '/file2.yml';

        $expected = <<<TEXT
{
  - follow: false
    host: hexlet.io
  - proxy: 123.234.53.22
  - timeout: 50
  + timeout: 20
  + verbose: true
}
TEXT;

        $actual = genDiff($file1, $file2);
        $this->assertEquals(trim($expected), trim($actual));
    }
}
