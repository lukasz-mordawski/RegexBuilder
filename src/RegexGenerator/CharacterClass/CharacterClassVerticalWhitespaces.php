<?php declare(strict_types=1);

namespace RegexGenerator\CharacterClass;

class CharacterClassVerticalWhitespaces implements CharacterClassInterface
{
    private $delimiter;

    public function render(): string
    {
        return '\v';
    }

    public function setDelimiter(string $delimiter): CharacterClassInterface
    {
        $this->delimiter = $delimiter;
        return $this;
    }
}