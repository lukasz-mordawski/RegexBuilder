<?php declare(strict_types=1);

namespace RegexGenerator\CharacterClass;

class CharacterClassDigits implements CharacterClassInterface
{
    private $delimiter;

    public function render(): string
    {
        return '\d';
    }

    public function setDelimiter(string $delimiter): CharacterClassInterface
    {
        $this->delimiter = $delimiter;
        return $this;
    }
}