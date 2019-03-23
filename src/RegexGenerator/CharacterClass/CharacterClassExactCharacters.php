<?php declare(strict_types=1);

namespace RegexGenerator\CharacterClass;

class CharacterClassExactCharacters implements CharacterClassInterface
{
    private $delimiter = '/';
    private $characters;

    public function __construct(string $characters)
    {
        $this->characters = $characters;
    }

    public function setDelimiter(string $delimiter): CharacterClassInterface
    {
        $this->delimiter = $delimiter;
        return $this;
    }

    public function render(): string
    {
        return preg_quote($this->characters, $this->delimiter);
    }
}