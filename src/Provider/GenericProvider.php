<?php

namespace YaFou\FakeMe\Provider;

class GenericProvider implements ProviderInterface
{
    public function getNames(): array
    {
        return [
            'boolean',
            'digit',
            'integer',
            'float',
            'letter',
            'randomElement'
        ];
    }

    public function boolean(): bool
    {
        return (bool)$this->integer(0, 1);
    }

    public function integer(int $min = 0, int $max = null): int
    {
        if (null === $max) {
            $max = mt_getrandmax();
        }

        return mt_rand($min, $max);
    }

    public function digit(): int
    {
        return $this->integer(0, 9);
    }

    public function float(float $min = 0, float $max = null, int $precision = null): float
    {
        if (null === $precision) {
            $precision = $this->integer(0, 12);
        }

        if (null === $max) {
            $max = $this->integer();
        }

        return round($min + ($this->integer() / mt_getrandmax()) * ($max - $min), $precision);
    }

    public function letter(): string
    {
        return chr($this->integer(97, 122));
    }

    public function randomElement(array $elements)
    {
        return array_rand($elements);
    }
}
