<?php

namespace YaFou\FakeMe;

use InvalidArgumentException;
use LogicException;
use YaFou\FakeMe\Provider\AddressProvider;
use YaFou\FakeMe\Provider\GenericProvider;
use YaFou\FakeMe\Provider\PersonProvider;
use YaFou\FakeMe\Provider\ProviderInterface;
use YaFou\FakeMe\Provider\TextProvider;
use YaFou\FakeMe\Provider\UuidProvider;
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
 *
 * @method title(string $gender = null): string
 * @method firstName(string $gender = null): string
 * @method lastName(): string
 * @method name(string $gender = null): string
 *
 * @method country(): string
 *
 * @method uuid1(): string
 * @method uuid4(): string
 * @method uuid6(): string
 */
class Generator
{
    private const DEFAULT_PROVIDERS = [
        GenericProvider::class,
        TextProvider::class,
        PersonProvider::class,
        AddressProvider::class,
        UuidProvider::class
    ];

    private const OWNER = 'YaFou';
    private const REPOSITORY = 'FakeMe';
    private const REF = 'main';
    private const RESOURCES_DIRECTORY = 'resources';
    private const HASHES_FILE = self::RESOURCES_DIRECTORY . '/hashes.json';

    /** @var ProviderInterface[] */
    private $providers;
    /** @var ResourceProviderInterface[] */
    private $resourceProviders;
    private $language;

    public function __construct(array $providers = [], array $resourceProviders = [], string $language = 'en_US')
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
        $this->language = $language;
    }

    public function getResource(string $providerName, string $name): array
    {
        if (!isset($this->resourceProviders[$providerName])) {
            throw new InvalidArgumentException(sprintf(
                'No resource provider found with the name "%s"',
                $providerName
            ));
        }

        return $this->resourceProviders[$providerName]->getResource($name);
    }

    public function getResourceForLanguage(string $providerName, string $name): array
    {
        return $this->resourceProviders[$providerName]->getResource(sprintf('%s/%s', $this->language, $name));
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

    public function parse(string $subject): string
    {
        $result = preg_replace_callback('/{{(\w+)}}/', function (array $matches) {
            return $this->{$matches[1]}();
        }, $subject);

        $result = str_replace('#', $this->digit(), $result);
        $result = str_replace('?', $this->letter(), $result);

        return $result;
    }
}
