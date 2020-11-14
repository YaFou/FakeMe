<?php

namespace YaFou\FakeMe\Tests\Provider;

use PHPUnit\Framework\TestCase;
use YaFou\FakeMe\Provider\AddressProvider;
use YaFou\FakeMe\Tests\GeneratorMock;

class AddressProviderTest extends TestCase
{
    private static $provider;

    public static function setUpBeforeClass(): void
    {
        self::$provider = new AddressProvider(new GeneratorMock());
    }

    public function testCountry()
    {
        $this->assertIsString(self::$provider->country());
    }

    public function testContinent()
    {
        $this->assertIsString(self::$provider->continent());
    }
}
