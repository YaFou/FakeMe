<?php

namespace YaFou\FakeMe\Provider;

class PersonProvider extends AbstractProvider
{
    public const GENDER_MALE = 'male';
    public const GENDER_FEMALE = 'female';

    private const NAME = [
        'firstName lastName',
        'title firstName lastName'
    ];

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
        $titles = $this->getResourceForLanguage()['titles'];

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
        $result = $this->generator->randomElement(static::NAME);
        $result = str_replace('firstName', $this->firstName($gender), $result);
        $result = str_replace('lastName', $this->lastName(), $result);
        $result = str_replace('title', $this->title($gender), $result);

        return $result;
    }

    public function firstName(string $gender = null): string
    {
        $firstNames = $this->getResourceForLanguage()['firstNames'];

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
            $this->getResourceForLanguage()['lastNames']
        );
    }

    protected function getResourceFile(): string
    {
        return 'person.json';
    }
}
