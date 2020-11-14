<?php

namespace YaFou\FakeMe\Tests;

use YaFou\FakeMe\Generator;
use YaFou\FakeMe\ResourceProvider\StorageResourceProvider;

class GeneratorMock extends Generator
{
    public function __construct(array $providers = [], array $resourceProviders = [], string $language = 'en_US')
    {
        $resourceProvider = new StorageResourceProvider(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'resources');
        parent::__construct($providers, array_merge(['main' => $resourceProvider], $resourceProviders), $language);
    }
}
