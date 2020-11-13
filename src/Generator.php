<?php

namespace YaFou\FakeMe;

use LogicException;
use YaFou\FakeMe\Provider\GenericProvider;
use YaFou\FakeMe\Provider\ProviderInterface;

/**
 * @method boolean(): bool
 * @method digit(): int
 * @method integer(int $min = 0, int $max = null): int
 * @method float(float $min = 0, float $max = null, int $precision = null): float
 * @method letter(): string
 * @method randomElement(array $elements)
 */
class Generator
{
    private const DEFAULT_PROVIDERS = [GenericProvider::class];

    /** @var ProviderInterface[] */
    private $providers;

    public function __construct(array $providers = [])
    {
        foreach (array_merge(self::DEFAULT_PROVIDERS, $providers) as $provider) {
            $this->providers[] = new $provider();
        }
    }

    public function __call($name, $arguments)
    {
        foreach ($this->providers as $provider) {
            if (in_array($name, $provider->getNames())) {
                return call_user_func_array([$provider, $name], $arguments);
            }
        }

        throw new LogicException(sprintf('No provider method found for "%s"', $name));
    }
}
