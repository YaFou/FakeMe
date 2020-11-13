<?php

namespace YaFou\FakeMe\Tests\ResourceProvider;

use LogicException;
use PHPUnit\Framework\TestCase;
use YaFou\FakeMe\ResourceProvider\GithubRepositoryResourceProvider;

class GithubRepositoryResourceProviderTest extends TestCase
{
    private const OWNER = 'YaFou';
    private const REPOSITORY = 'FakeMe';
    private const REF = 'main';

    public function testGetResource()
    {
        $provider = new GithubRepositoryResourceProvider(self::OWNER, self::REPOSITORY, self::REF);
        $this->assertSame('yafou/fakeme', $provider->getResource('composer.json')['name']);
    }

    public function testGetResourceWithDirectory()
    {
        $provider = new GithubRepositoryResourceProvider(self::OWNER, self::REPOSITORY, self::REF, 'resources');
        $this->assertIsArray($provider->getResource('text.json'));
    }

    public function testIsFreshWithoutSettingTheHashesFile()
    {
        $this->expectException(LogicException::class);
        $provider = new GithubRepositoryResourceProvider(self::OWNER, self::REPOSITORY, self::REF, 'resources');
        $provider->isFresh('text.json', '');
    }

    public function testIsNotFresh()
    {
        $provider = new GithubRepositoryResourceProvider(self::OWNER, self::REPOSITORY, self::REF, 'resources');
        $provider->setHashesFile('resources/hashes.json');
        $this->assertFalse($provider->isFresh('text.json', ''));
    }
}
