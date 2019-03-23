<?php declare(strict_types=1);

namespace RegexGenerator\CharacterClass;

class CharacterClassWhitespaces implements CharacterClassInterface
{
    private $delimiter;

    public function render(): string
    {
        return '\s';
    }

    public function setDelimiter(string $delimiter): CharacterClassInterface
    {
        $this->delimiter = $delimiter;
        return $this;
    }
}