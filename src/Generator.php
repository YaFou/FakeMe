<?php

namespace YaFou\FakeMe;

use LogicException;
use YaFou\FakeMe\Provider\GenericProvider;
use YaFou\FakeMe\Provider\ProviderInterface;
use YaFou\FakeMe\ResourceProvider\GithubRepositoryResourceProvider;
use YaFou\FakeMe\ResourceProvider\ResourceProviderInterface;

/**
 * @method boolean(): bool
 * @method digit(): int
 * @method integer(int $min = 0, int $max = null): int
 * @method float(float $min = 0, float $max = null, int $precision = null): float
 * @method randomElement(array $elements)
 *
 * @method letter(): string
 * @method word(): string
 * @method words(int $number, bool $stringify = false)
 * @method sentences(int $number = 1, int $minWords = 3, int $maxWords = 15): string
 */
class Generator
{
    private const DEFAULT_PROVIDERS = [GenericProvider::class];
    private const OWNER = 'YaFou';
    private const REPOSITORY = 'FakeMe';
    private const REF = 'main';
    private const RESOURCES_DIRECTORY = 'resources';
    private const HASHES_FILE = self::RESOURCES_DIRECTORY . '/hashes.json';

    /** @var ProviderInterface[] */
    private $providers;
    /** @var ResourceProviderInterface[] */
    private $resourceProviders;

    public function __construct(array $providers = [], array $resourceProviders = [])
    {
        foreach (array_merge(self::DEFAULT_PROVIDERS, $providers) as $provider) {
            $this->providers[] = new $provider($this);
        }

        $mainResourceProvider = new GithubRepositoryResourceProvider(
            self::OWNER,
            self::REPOSITORY,
            self::REF,
            self::RESOURCES_DIRECTORY
        );

        $mainResourceProvider->enableCache(self::HASHES_FILE);
        $this->resourceProviders = array_merge(['main' => $mainResourceProvider], $resourceProviders);
    }

    public function getResource(string $providerName, string $name): array
    {
        return $this->resourceProviders[$providerName]->getResource($name);
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
