<?php

namespace YaFou\FakeMe\Tests;

use Generator;
use InvalidArgumentException;
use LogicException;
use YaFou\FakeMe\Provider\ProviderInterface;
use YaFou\FakeMe\ResourceProvider\ResourceProviderInterface;

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

    public function testGetResource()
    {
        $generator = new GeneratorMock();
        $this->assertIsArray($generator->getResource('main', 'text.json'));
    }

    public function testFailedGetResource()
    {
        $this->expectExceptionMessageMatches('/failed/');
        $generator = new GeneratorMock();
        $generator->getResource('main', 'failed');
    }

    public function testGetResourceForLanguage()
    {
        $generator = new GeneratorMock();
        $this->assertIsArray($generator->getResourceForLanguage('main', 'person.json'));
    }

    public function testFailedGetResourceForLanguage()
    {
        $this->expectExceptionMessageMatches('/en_US\/failed/');
        $generator = new GeneratorMock();
        $generator->getResourceForLanguage('main', 'failed');
    }

    public function testFailedGetResourceForLanguageWithCustomLanguage()
    {
        $this->expectExceptionMessageMatches('/fr_FR\/failed/');
        $generator = new GeneratorMock([], [], 'fr_FR');
        $generator->getResourceForLanguage('main', 'failed');
    }

    public function testGetResourceWithUnknownResourceProvider()
    {
        $this->expectException(InvalidArgumentException::class);
        $generator = new GeneratorMock();
        $generator->getResource('unknown', 'text.json');
    }

    public function testGetResourceWithCustomResourceProvider()
    {
        $provider = $this->createMock(ResourceProviderInterface::class);
        $provider->expects($this->once())->method('getResource')->with('text.json')->willReturn([]);
        $generator = new GeneratorMock([], ['provider' => $provider]);
        $this->assertEmpty($generator->getResource('provider', 'text.json'));
    }

    /**
     * @dataProvider provideParse
     * @param string $expected
     * @param string $actual
     */
    public function testParse(string $expected, string $actual)
    {
        $expected = "/^$expected$/";
        $generator = new GeneratorMock();
        $this->assertMatchesRegularExpression($expected, $generator->parse($actual));
    }

    public function provideParse(): Generator
    {
        yield ['value', 'value'];
        yield ['str \d str', 'str {{digit}} str'];
        yield ['str \d \d+ str', 'str {{digit}} {{integer}} str'];
        yield ['\d{3}', '###'];
        yield ['\w{3}', '???'];
        yield ['\w{3} \d{5}', '??? #####'];
    }
}
