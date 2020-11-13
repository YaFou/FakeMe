<?php

namespace YaFou\FakeMe\ResourceProvider;

use LogicException;

class GithubRepositoryResourceProvider implements FreshResourceProviderInterface
{
    public const ALGORITHM_MD5 = 'md5';
    public const ALGORITHM_SHA1 = 'sha1';
    private const URL = 'https://raw.githubusercontent.com/%s/%s/%s';

    private $owner;
    private $repository;
    private $ref;
    private $url;
    private $hashesFile;
    private $hashAlgorithm;

    public function __construct(string $owner, string $repository, string $ref, string $directory = null)
    {
        $this->owner = $owner;
        $this->repository = $repository;
        $this->ref = $ref;
        $this->url = sprintf(self::URL, $owner, $repository, $ref);

        if (null !== $directory) {
            $this->url = sprintf('%s/%s', $this->url, $directory);
        }
    }

    public function setHashesFile(string $hashesFile, string $hashAlgorithm = self::ALGORITHM_MD5): void
    {
        $this->hashesFile = $hashesFile;
        $this->hashAlgorithm = $hashAlgorithm;
    }

    public function getResource(string $name): array
    {
        return $this->fetch(sprintf('%s/%s', $this->url, $name));
    }

    private function fetch(string $url): array
    {
        return json_decode(file_get_contents($url), true);
    }

    public function isFresh(string $name, string $content): bool
    {
        if (null === $this->hashesFile) {
            throw new LogicException('You must define a hashes file and an algorithm');
        }

        $hash = ($this->hashAlgorithm)($content);
        $hashes = $this->fetch(sprintf(self::URL . '/%s', $this->owner, $this->repository, $this->ref, $this->hashesFile));

        return $hashes[$name] === $hash;
    }
}
