<?php

namespace YaFou\FakeMe\Tests\Provider;

use YaFou\FakeMe\Provider\TextProvider;
use YaFou\FakeMe\Tests\GeneratorMock;
use YaFou\FakeMe\Tests\TestCase;

class TextProviderTest extends TestCase
{
    private static $provider;

    public static function setUpBeforeClass(): void
    {
        self::$provider = new TextProvider(new GeneratorMock());
    }

    public function testLetter()
    {
        $this->assertMatchesRegularExpression('/^[a-z]$/', self::$provider->letter());
    }

    public function testWord()
    {
        $this->assertIsString(self::$provider->word());
    }

    public function testWords()
    {
        $this->assertCount(3, self::$provider->words(3));
        $this->assertCount(5, self::$provider->words(5));
    }

    public function testWordsWithSlugify()
    {
        $words = self::$provider->words(3, true);
        $this->assertIsString($words);
        $this->assertCount(3, explode(' ', $words));
    }

    public function testSentences()
    {
        $sentence = self::$provider->sentences();
        $this->assertMatchesRegularExpression('/^[\w\s]+\.$/', $sentence);
    }

    public function testSentencesMultiple()
    {
        $sentences = self::$provider->sentences(2);
        $this->assertMatchesRegularExpression('/^([\w\s]+\.){2}$/', $sentences);
    }

    public function testSentencesWithCustomNumberOfWords()
    {
        $sentence = self::$provider->sentences(1, 1, 5);
        $this->assertLessThanOrEqual(5, count(explode(' ', $sentence)));
    }
}
