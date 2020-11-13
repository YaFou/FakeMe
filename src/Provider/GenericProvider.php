<?php

namespace YaFou\FakeMe\Provider;

class GenericProvider extends AbstractProvider
{
    public function getNames(): array
    {
        return [
            'boolean',
            'digit',
            'integer',
            'float',
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

    public function randomElement(array $elements)
    {
        return $elements[$this->integer(0, count(array_keys($elements)) - 1)];
    }
}
