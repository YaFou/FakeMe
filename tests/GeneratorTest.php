<?php

namespace YaFou\FakeMe\Tests;

use LogicException;
use PHPUnit\Framework\TestCase;
use YaFou\FakeMe\Generator;
use YaFou\FakeMe\Provider\ProviderInterface;

class GeneratorTest extends TestCase
{
    public function testCallFunction()
    {
        $generator = new Generator();
        $this->assertIsBool($generator->boolean());
    }

    public function testCallUnknownFunction()
    {
        $this->expectException(LogicException::class);
        $generator = new Generator();
        $generator->unknownFunction();
    }

    public function testAddProvider()
    {
        $provider = new class implements ProviderInterface {
            public function getNames(): array
            {
                return ['function'];
            }

            public function function ()
            {
                return 'value';
            }
        };

        $generator = new Generator([$provider]);
        $this->assertSame('value', $generator->function());
    }
}
