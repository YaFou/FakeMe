<?php

namespace YaFou\FakeMe\Tests\ResourceProvider;

use PHPUnit\Framework\TestCase;
use YaFou\FakeMe\ResourceProvider\GithubRepositoryResourceProvider;

class GithubRepositoryResourceProviderTest extends TestCase
{
    private const OWNER = 'YaFou';
    private const REPOSITORY = 'FakeMe';
    private const REF = 'main';
    private const RESOURCES_DIRECTORY = 'resources';
    private const NAME = 'yafou/fakeme';

    public function testGetResource()
    {
        $provider = new GithubRepositoryResourceProvider(self::OWNER, self::REPOSITORY, self::REF);
        $this->assertSame('' . self::NAME . '', $provider->getResource('composer.json')['name']);
    }

    public function testGetResourceWithCustomDirectory()
    {
        $provider = new GithubRepositoryResourceProvider(
            self::OWNER,
            self::REPOSITORY,
            self::REF,
            self::RESOURCES_DIRECTORY
        );

        $this->assertIsArray($provider->getResource('text.json'));
    }

    public function testGetResourceWithCache()
    {
        $directory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'FakeMe_Tests';
        $this->assertIsArray($this->makeProvider($directory)->getResource('text.json'));
        $this->assertFileExists($directory . DIRECTORY_SEPARATOR . 'hashes.json');
        $this->assertIsArray($this->makeProvider($directory)->getResource('text.json'));

        foreach (glob($directory . DIRECTORY_SEPARATOR . '*') as $file) {
            unlink($file);
        }

        rmdir($directory);
    }

    private function makeProvider(string $directory): GithubRepositoryResourceProvider
    {
        $provider = new GithubRepositoryResourceProvider(
            self::OWNER,
            self::REPOSITORY,
            self::REF,
            self::RESOURCES_DIRECTORY
        );

        $provider->enableCache(
            self::RESOURCES_DIRECTORY . '/hashes.json',
            $directory
        );

        return $provider;
    }
}
