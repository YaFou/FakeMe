<?php

namespace YaFou\FakeMe\ResourceProvider;

use InvalidArgumentException;

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

        $filename = $this->directory . DIRECTORY_SEPARATOR . $name;

        if (!file_exists($filename)) {
            throw new InvalidArgumentException(sprintf('Failed to open "%s"', $filename));
        }

        return $this->resolvedResources[$name] = json_decode(
            file_get_contents($filename),
            true
        );
    }
}
