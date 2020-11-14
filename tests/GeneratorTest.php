<?php

namespace YaFou\FakeMe\Tests;

use LogicException;
use PHPUnit\Framework\TestCase;
use YaFou\FakeMe\Provider\ProviderInterface;

class GeneratorTest extends TestCase
{
    public function testCallFunction()
    {
        $generator = new GeneratorMock();
        $this->assertIsBool($generator->boolean());
    }

    public function testCallUnknownFunction()
    {
        $this->expectException(LogicException::class);
        $generator = new GeneratorMock();
        $generator->unknownFunction();
    }

    public function testAddProvider()
    {
        $provider = new class implements ProviderInterface {
            public function getNames(): array
            {
                return ['value'];
            }

            public function getResourceProviders(): array
            {
                return [];
            }

            public function value()
            {
                return 'value';
            }
        };

        $generator = new GeneratorMock([$provider]);
        $this->assertSame('value', $generator->value());
    }
}
