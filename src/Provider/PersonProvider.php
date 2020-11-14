<?php

namespace YaFou\FakeMe\Provider;

class PersonProvider extends AbstractProvider
{
    public const GENDER_MALE = 'male';
    public const GENDER_FEMALE = 'female';

    public function getNames(): array
    {
        return [
            'title',
            'firstName',
            'lastName',
            'name'
        ];
    }

    public function title(string $gender = null): string
    {
        $titles = $this->generator->getResourceForLanguage('main', 'person.json')['titles'];

        if (null === $gender) {
            return $this->generator->randomElement(array_merge(
                $titles[self::GENDER_MALE],
                $titles[self::GENDER_FEMALE]
            ));
        }

        return $this->generator->randomElement($titles[$gender]);
    }

    public function name(string $gender = null): string
    {
        return sprintf('%s %s', $this->firstName($gender), $this->lastName());
    }

    public function firstName(string $gender = null): string
    {
        $firstNames = $this->generator->getResourceForLanguage('main', 'person.json')['firstNames'];

        if (null === $gender) {
            return $this->generator->randomElement(array_merge(
                $firstNames[self::GENDER_MALE],
                $firstNames[self::GENDER_FEMALE]
            ));
        }

        return $this->generator->randomElement($firstNames[$gender]);
    }

    public function lastName(): string
    {
        return $this->generator->randomElement(
            $this->generator->getResourceForLanguage('main', 'person.json')['lastNames']
        );
    }
}
