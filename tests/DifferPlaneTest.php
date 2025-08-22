<?php

namespace Hexlet\Code\Tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferPlaneTest extends TestCase
{
    private string $fixturesDir;

    protected function setUp(): void
    {
        $this->fixturesDir = __DIR__ . '/fixtures';
    }

    public function testGenDiffPlainFormatJson(): void
    {
        $file1 = "{$this->fixturesDir}/fileNested1.json";
        $file2 = "{$this->fixturesDir}/fileNested2.json";

        $expected = <<<OUTPUT
Property 'common.follow' was added with value: false
Property 'common.setting2' was removed
Property 'common.setting3' was updated. From true to null
Property 'common.setting4' was added with value: 'blah blah'
Property 'common.setting5' was added with value: [complex value]
Property 'common.setting6.doge.wow' was updated. From '' to 'so much'
Property 'common.setting6.ops' was added with value: 'vops'
Property 'group1.baz' was updated. From 'bas' to 'bars'
Property 'group1.nest' was updated. From [complex value] to 'str'
Property 'group2' was removed
Property 'group3' was added with value: [complex value]
OUTPUT;

        $this->assertSame($expected, genDiff($file1, $file2, 'plain'));
    }

    public function testGenDiffPlainFormatYaml(): void
    {
        $file1 = "{$this->fixturesDir}/fileNested1.yml";
        $file2 = "{$this->fixturesDir}/fileNested2.yml";

        $expected = <<<OUTPUT
Property 'common.follow' was added with value: false
Property 'common.setting2' was removed
Property 'common.setting3' was updated. From true to null
Property 'common.setting4' was added with value: 'blah blah'
Property 'common.setting5' was added with value: [complex value]
Property 'common.setting6.doge.wow' was updated. From '' to 'so much'
Property 'common.setting6.ops' was added with value: 'vops'
Property 'group1.baz' was updated. From 'bas' to 'bars'
Property 'group1.nest' was updated. From [complex value] to 'str'
Property 'group2' was removed
Property 'group3' was added with value: [complex value]
OUTPUT;

        $this->assertSame($expected, genDiff($file1, $file2, 'plain'));
    }
}
