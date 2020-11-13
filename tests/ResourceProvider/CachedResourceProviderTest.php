<?php

namespace YaFou\FakeMe\Tests\ResourceProvider;

use PHPUnit\Framework\TestCase;
use YaFou\FakeMe\ResourceProvider\CachedResourceProvider;
use YaFou\FakeMe\ResourceProvider\FreshResourceProviderInterface;

class CachedResourceProviderTest extends TestCase
{
    public function testIsFresh()
    {
        $wrappedProvider = $this->createMock(FreshResourceProviderInterface::class);
        $wrappedProvider->expects($this->exactly(2))->method('isFresh')->willReturnOnConsecutiveCalls(false, true);
        $wrappedProvider->expects($this->once())->method('getResource')->willReturnOnConsecutiveCalls(['key' => 'value1'], ['key' => 'value2']);

        $directory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'FakeMe_Tests';
        $filename = $directory . DIRECTORY_SEPARATOR . 'name';

        $provider = new CachedResourceProvider($wrappedProvider, $directory);
        $this->assertSame(['key' => 'value1'], $provider->getResource('name'));

        $this->assertFileExists($filename);
        $this->assertSame('{"key":"value1"}', file_get_contents($filename));

        $this->assertSame(['key' => 'value1'], $provider->getResource('name'));

        unlink($filename);
        rmdir($directory);
    }
}
