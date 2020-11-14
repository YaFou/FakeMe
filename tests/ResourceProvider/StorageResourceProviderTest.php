<?php

namespace YaFou\FakeMe\Tests\ResourceProvider;

use PHPUnit\Framework\TestCase;
use YaFou\FakeMe\ResourceProvider\StorageResourceProvider;

class StorageResourceProviderTest extends TestCase
{
    public function testGetResource()
    {
        $filename = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'FakeMe_Tests' . DIRECTORY_SEPARATOR . 'name';
        mkdir(dirname($filename));
        file_put_contents($filename, '{"key":"value"}');

        $provider = new StorageResourceProvider(dirname($filename));
        $this->assertSame(['key' => 'value'], $provider->getResource('name'));

        unlink($filename);
        rmdir(dirname($filename));
    }
}
