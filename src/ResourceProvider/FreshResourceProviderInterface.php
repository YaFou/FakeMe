<?php

namespace YaFou\FakeMe\ResourceProvider;

interface FreshResourceProviderInterface extends ResourceProviderInterface
{
    public function isFresh(string $name, string $content): bool;
}
