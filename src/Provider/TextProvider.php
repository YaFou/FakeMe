<?php

namespace YaFou\FakeMe\Provider;

class TextProvider extends AbstractProvider
{
    public function getNames(): array
    {
        return [
            'letter',
            'word',
            'words',
            'sentences'
        ];
    }

    public function letter(): string
    {
        return chr($this->generator->integer(97, 122));
    }

    public function sentences(int $number = 1, int $minWords = 3, int $maxWords = 15): string
    {
        $sentences = [];

        for ($i = 0; $i < $number; $i++) {
            $sentences[] = ucfirst($this->words($this->generator->integer($minWords, $maxWords), true) . '.');
        }

        return join(' ', $sentences);
    }

    public function words(int $number, bool $stringify = false)
    {
        $words = [];

        for ($i = 0; $i < $number; $i++) {
            $words[] = $this->word();
        }

        return $stringify ? join(' ', $words) : $words;
    }

    public function word(): string
    {
        return $this->generator->randomElement($this->getResource());
    }

    protected function getResourceFile(): string
    {
        return 'text.json';
    }
}
