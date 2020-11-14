<?php

namespace YaFou\FakeMe\Provider;

use LogicException;
use YaFou\FakeMe\Generator;

abstract class AbstractProvider implements ProviderInterface
{
    protected $generator;

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }

    protected function getResourceFile(): string
    {
        throw new LogicException('No file has been set');
    }

    protected function getResourceProviderName(): string
    {
        return 'main';
    }

    protected function getResourceForLanguage(): array
    {
        return $this->generator->getResourceForLanguage($this->getResourceProviderName(), $this->getResourceFile());
    }

    protected function getResource(): array
    {
        return $this->generator->getResource($this->getResourceProviderName(), $this->getResourceFile());
    }
}
