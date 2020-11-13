<?php

namespace YaFou\FakeMe\ResourceProvider;

class CachedResourceProvider implements ResourceProviderInterface
{
    private $wrappedResourceProvider;
    private $directory;

    public function __construct(FreshResourceProviderInterface $wrappedResourceProvider, string $directory = null)
    {
        if (null === $directory) {
            $directory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'FakeMe';
        }

        $this->wrappedResourceProvider = $wrappedResourceProvider;
        $this->directory = $directory;
    }

    public function getResource(string $name): array
    {
        if (!file_exists($this->directory)) {
            mkdir($this->directory);
        }

        $filename = $this->directory . DIRECTORY_SEPARATOR . $name;

        if (file_exists($filename) && $this->wrappedResourceProvider->isFresh($name, $content = file_get_contents($filename))) {
            return json_decode($content, true);
        }

        file_put_contents($filename, json_encode($content = $this->wrappedResourceProvider->getResource($name)));

        return $content;
    }
}
