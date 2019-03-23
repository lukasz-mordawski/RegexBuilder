<?php declare(strict_types=1);

namespace RegexGenerator\CharacterClass;

class CharacterClassWord implements CharacterClassInterface
{
    private $delimiter;

    public function render(): string
    {
        return '\w';
    }

    public function setDelimiter(string $delimiter): CharacterClassInterface
    {
        $this->delimiter = $delimiter;
        return $this;
    }
}