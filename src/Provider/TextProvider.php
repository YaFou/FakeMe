<?php

namespace YaFou\FakeMe\Provider;

class TextProvider extends AbstractProvider
{
    private const WORDS = [
        'alias',
        'consequatur',
        'aut',
        'perferendis',
        'sit',
        'voluptatem',
        'accusantium',
        'doloremque',
        'aperiam',
        'eaque',
        'ipsa',
        'quae',
        'ab',
        'illo',
        'inventore',
        'veritatis',
        'et',
        'quasi',
        'architecto',
        'beatae',
        'vitae',
        'dicta',
        'sunt',
        'explicabo',
        'aspernatur',
        'aut',
        'odit',
        'aut',
        'fugit',
        'sed',
        'quia',
        'consequuntur',
        'magni',
        'dolores',
        'eos',
        'qui',
        'ratione',
        'voluptatem',
        'sequi',
        'nesciunt',
        'neque',
        'dolorem',
        'ipsum',
        'quia',
        'dolor',
        'sit',
        'amet',
        'consectetur',
        'adipisci',
        'velit',
        'sed',
        'quia',
        'non',
        'numquam',
        'eius',
        'modi',
        'tempora',
        'incidunt',
        'ut',
        'labore',
        'et',
        'dolore',
        'magnam',
        'aliquam',
        'quaerat',
        'voluptatem',
        'ut',
        'enim',
        'ad',
        'minima',
        'veniam',
        'quis',
        'nostrum',
        'exercitationem',
        'ullam',
        'corporis',
        'nemo',
        'enim',
        'ipsam',
        'voluptatem',
        'quia',
        'voluptas',
        'sit',
        'suscipit',
        'laboriosam',
        'nisi',
        'ut',
        'aliquid',
        'ex',
        'ea',
        'commodi',
        'consequatur',
        'quis',
        'autem',
        'vel',
        'eum',
        'iure',
        'reprehenderit',
        'qui',
        'in',
        'ea',
        'voluptate',
        'velit',
        'esse',
        'quam',
        'nihil',
        'molestiae',
        'et',
        'iusto',
        'odio',
        'dignissimos',
        'ducimus',
        'qui',
        'blanditiis',
        'praesentium',
        'laudantium',
        'totam',
        'rem',
        'voluptatum',
        'deleniti',
        'atque',
        'corrupti',
        'quos',
        'dolores',
        'et',
        'quas',
        'molestias',
        'excepturi',
        'sint',
        'occaecati',
        'cupiditate',
        'non',
        'provident',
        'sed',
        'ut',
        'perspiciatis',
        'unde',
        'omnis',
        'iste',
        'natus',
        'error',
        'similique',
        'sunt',
        'in',
        'culpa',
        'qui',
        'officia',
        'deserunt',
        'mollitia',
        'animi',
        'id',
        'est',
        'laborum',
        'et',
        'dolorum',
        'fuga',
        'et',
        'harum',
        'quidem',
        'rerum',
        'facilis',
        'est',
        'et',
        'expedita',
        'distinctio',
        'nam',
        'libero',
        'tempore',
        'cum',
        'soluta',
        'nobis',
        'est',
        'eligendi',
        'optio',
        'cumque',
        'nihil',
        'impedit',
        'quo',
        'porro',
        'quisquam',
        'est',
        'qui',
        'minus',
        'id',
        'quod',
        'maxime',
        'placeat',
        'facere',
        'possimus',
        'omnis',
        'voluptas',
        'assumenda',
        'est',
        'omnis',
        'dolor',
        'repellendus',
        'temporibus',
        'autem',
        'quibusdam',
        'et',
        'aut',
        'consequatur',
        'vel',
        'illum',
        'qui',
        'dolorem',
        'eum',
        'fugiat',
        'quo',
        'voluptas',
        'nulla',
        'pariatur',
        'at',
        'vero',
        'eos',
        'et',
        'accusamus',
        'officiis',
        'debitis',
        'aut',
        'rerum',
        'necessitatibus',
        'saepe',
        'eveniet',
        'ut',
        'et',
        'voluptates',
        'repudiandae',
        'sint',
        'et',
        'molestiae',
        'non',
        'recusandae',
        'itaque',
        'earum',
        'rerum',
        'hic',
        'tenetur',
        'a',
        'sapiente',
        'delectus',
        'ut',
        'aut',
        'reiciendis',
        'voluptatibus',
        'maiores',
        'doloribus',
        'asperiores',
        'repellat'
    ];

    public function getNames(): array
    {
        return [
            'letter',
            'word'
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
        return $this->generator->randomElement(static::WORDS);
    }
}