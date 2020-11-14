<?php

namespace YaFou\FakeMe\Provider;

use LogicException;
use Ramsey\Uuid\Uuid;

class UuidProvider implements ProviderInterface
{
    public function getNames(): array
    {
        return [
            'uuid1',
            'uuid4',
            'uuid6'
        ];
    }

    public function uuid1(): string
    {
        $this->ensureUuidIsInstalled(__METHOD__);

        return Uuid::uuid1();
    }

    private function ensureUuidIsInstalled(string $method): void
    {
        if (!class_exists(Uuid::class)) {
            throw new LogicException(sprintf('You must install "ramsey/uuid" to use %s::%s', self::class, $method));
        }
    }

    public function uuid4(): string
    {
        $this->ensureUuidIsInstalled(__METHOD__);

        return Uuid::uuid4();
    }

    public function uuid6(): string
    {
        $this->ensureUuidIsInstalled(__METHOD__);

        return Uuid::uuid6();
    }
}
