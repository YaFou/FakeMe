<?php

namespace YaFou\FakeMe\ResourceProvider;

interface ResourceProviderInterface
{
    public function getResource(string $name): array;
}
