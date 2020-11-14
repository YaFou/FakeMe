<?php

namespace YaFou\FakeMe\ResourceProvider;

class GithubRepositoryResourceProvider implements ResourceProviderInterface
{
    private const URL = 'https://raw.githubusercontent.com/%s/%s/%s';
    private const HASHES_FILE = 'hashes.json';

    private $owner;
    private $repository;
    private $ref;
    private $url;
    private $hashesFile;
    private $cacheDirectory;
    private $remoteHashes;
    private $localHashes;
    private $resolvedResources = [];

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

    public function enableCache(string $hashesFile, string $cacheDirectory = null): void
    {
        if (null === $cacheDirectory) {
            $cacheDirectory = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'FakeMe';
        }

        $this->hashesFile = $hashesFile;
        $this->cacheDirectory = $cacheDirectory;
    }

    public function getResource(string $name): array
    {
        if (isset($this->resolvedResources[$name])) {
            return $this->resolvedResources[$name];
        }

        if (null !== $this->hashesFile) {
            $localHashesFile = $this->cacheDirectory . DIRECTORY_SEPARATOR . self::HASHES_FILE;

            if (!file_exists($this->cacheDirectory)) {
                mkdir($this->cacheDirectory, 0777, true);
            }

            if (!file_exists($localHashesFile)) {
                file_put_contents($localHashesFile, '{}');
            }

            if (null === $this->remoteHashes) {
                $this->remoteHashes = $this->fetch(sprintf(
                    self::URL . '/%s',
                    $this->owner,
                    $this->repository,
                    $this->ref,
                    $this->hashesFile
                ));
            }

            if (null === $this->localHashes) {
                $this->localHashes = $this->fetch($localHashesFile);
            }

            $hash = $this->remoteHashes[$name];

            if (isset($this->localHashes[$name])) {
                $hashes = $this->localHashes[$name];

                if (in_array($hash, $hashes)) {
                    return $this->resolvedResources[$name] = $this->fetch(
                        $this->cacheDirectory . DIRECTORY_SEPARATOR . $hash
                    );
                }
            }

            $content = $this->fetch(sprintf('%s/%s', $this->url, $name));
            file_put_contents($this->cacheDirectory . DIRECTORY_SEPARATOR . $hash, json_encode($content));
            $this->localHashes[$name][] = $hash;
            file_put_contents($localHashesFile, json_encode($this->localHashes));

            return $this->resolvedResources[$name] = $content;
        }

        return $this->resolvedResources[$name] = $this->fetch(sprintf('%s/%s', $this->url, $name));
    }

    private function fetch(string $filename): array
    {
        return json_decode(file_get_contents($filename), true);
    }
}
