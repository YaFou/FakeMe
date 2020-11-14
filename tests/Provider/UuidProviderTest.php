<?php

namespace YaFou\FakeMe\Tests\Provider;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use YaFou\FakeMe\Provider\UuidProvider;

class UuidProviderTest extends TestCase
{
    public function testUuid1()
    {
        $provider = new UuidProvider();
        $this->assertTrue(Uuid::isValid($provider->uuid1()));
    }

    public function testUuid4()
    {
        $provider = new UuidProvider();
        $this->assertTrue(Uuid::isValid($provider->uuid4()));
    }

    public function testUuid6()
    {
        $provider = new UuidProvider();
        $this->assertTrue(Uuid::isValid($provider->uuid6()));
    }
}
