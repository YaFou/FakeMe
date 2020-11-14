<?php

namespace YaFou\FakeMe\ResourceProvider;

class StorageResourceProvider implements ResourceProviderInterface
{
    private $directory;
    private $resolvedResources = [];

    public function __construct(string $directory)
    {
        $this->directory = $directory;
    }

    public function getResource(string $name): array
    {
        if (isset($this->resolvedResources[$name])) {
            return $this->resolvedResources[$name];
        }

        return $this->resolvedResources[$name] = json_decode(
            file_get_contents($this->directory . DIRECTORY_SEPARATOR . $name),
            true
        );
    }
}
