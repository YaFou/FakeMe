<?php

namespace YaFou\FakeMe\Provider;

class AddressProvider extends AbstractProvider
{
    public function getNames(): array
    {
        return [
            'country',
            'continent'
        ];
    }

    public function country(): string
    {
        return $this->generator->randomElement($this->getResourceForLanguage()['countries']);
    }

    public function continent(): string
    {
        return $this->generator->randomElement($this->getResourceForLanguage()['continents']);
    }

    protected function getResourceFile(): string
    {
        return 'address.json';
    }
}
