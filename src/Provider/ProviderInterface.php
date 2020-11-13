<?php

namespace YaFou\FakeMe\Provider;

interface ProviderInterface
{
    public function getNames(): array;

    public function getResourceProviders(): array;
}
