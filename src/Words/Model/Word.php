<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 14.11.18
 * Time: 20:46
 */

namespace App\Words\Model;

class Word
{
    /**
     * @var string
     */
    private $word;
    /**
     * @var string
     */
    private $translation;

    public function __construct(string $word, string $translation)
    {
        $this->word = $word;
        $this->translation = $translation;
    }

    /**
     * @return string
     */
    public function getWord(): string
    {
        return $this->word;
    }

    /**
     * @param string $word
     */
    public function setWord(string $word): void
    {
        $this->word = $word;
    }

    public static function createFromArray(array $array): self
    {
        return new self(
            $array[0],
            $array[1]
        );
    }
    /**
     * @return string
     */
    public function getTranslation(): string
    {
        return $this->translation;
    }

    /**
     * @param string $translation
     */
    public function setTranslation(string $translation): void
    {
        $this->translation = $translation;
    }
}