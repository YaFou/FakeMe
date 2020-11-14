<?php

namespace YaFou\FakeMe\Tests\Provider;

use PHPUnit\Framework\TestCase;
use YaFou\FakeMe\Provider\PersonProvider;
use YaFou\FakeMe\Tests\GeneratorMock;

class PersonProviderTest extends TestCase
{
    private static $provider;

    public static function setUpBeforeClass(): void
    {
        self::$provider = new PersonProvider(new GeneratorMock());
    }

    public function testTitle()
    {
        $this->assertIsString(self::$provider->title());
        $this->assertIsString(self::$provider->title(PersonProvider::GENDER_MALE));
        $this->assertIsString(self::$provider->title(PersonProvider::GENDER_FEMALE));
    }

    public function testFirstName()
    {
        $this->assertIsString(self::$provider->firstName());
        $this->assertIsString(self::$provider->firstName(PersonProvider::GENDER_MALE));
        $this->assertIsString(self::$provider->firstName(PersonProvider::GENDER_FEMALE));
    }

    public function testName()
    {
        $this->assertIsString(self::$provider->name());
        $this->assertIsString(self::$provider->name(PersonProvider::GENDER_MALE));
        $this->assertIsString(self::$provider->name(PersonProvider::GENDER_FEMALE));
    }

    public function testLastName()
    {
        $this->assertIsString(self::$provider->lastName());
    }
}
