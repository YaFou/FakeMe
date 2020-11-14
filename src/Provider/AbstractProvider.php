<?php

namespace YaFou\FakeMe\Provider;

use YaFou\FakeMe\Generator;

abstract class AbstractProvider implements ProviderInterface
{
    protected $generator;

    public function __construct(Generator $generator)
    {
        $this->generator = $generator;
    }
}
