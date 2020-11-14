<?php

namespace YaFou\FakeMe\Tests\Provider;

use YaFou\FakeMe\Provider\GenericProvider;
use YaFou\FakeMe\Tests\TestCase;

class GenericProviderTest extends TestCase
{
    private static $provider;

    public static function setUpBeforeClass(): void
    {
        self::$provider = new GenericProvider();
    }

    public function testBoolean()
    {
        $this->assertIsBool(self::$provider->boolean());
    }

    public function testDigit()
    {
        $digit = self::$provider->digit();
        $this->assertGreaterThanOrEqual(0, $digit);
        $this->assertLessThanOrEqual(9, $digit);
    }

    public function testInteger()
    {
        $integer = self::$provider->integer();
        $this->assertGreaterThanOrEqual(0, $integer);
        $this->assertLessThanOrEqual(mt_getrandmax(), $integer);
    }

    public function testIntegerWithCustomRange()
    {
        $integer = self::$provider->integer(-10, -1);
        $this->assertGreaterThanOrEqual(-10, $integer);
        $this->assertLessThanOrEqual(-1, $integer);
    }

    public function testFloat()
    {
        $float = self::$provider->float();
        $this->assertIsFloat($float);
        $this->assertGreaterThanOrEqual(0, $float);
        $this->assertLessThanOrEqual(mt_getrandmax(), $float);
    }

    public function testFloatWithCustomRange()
    {
        $float = self::$provider->float(-10, -1);
        $this->assertIsFloat($float);
        $this->assertGreaterThanOrEqual(-10, $float);
        $this->assertLessThanOrEqual(-1, $float);
    }

    public function testFloatWithCustomPrecision()
    {
        $float = self::$provider->float(0, null, 2);
        $decimals = explode('.', $float)[1] ?? '';
        $this->assertLessThanOrEqual(2, strlen($decimals));
    }

    public function testRandomElements()
    {
        $elements = ['value1', 'value2', 'value3', 'value4', 'value5'];
        $this->assertContains(self::$provider->randomElement($elements), $elements);
    }
}
