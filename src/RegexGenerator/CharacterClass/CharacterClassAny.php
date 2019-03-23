<?php declare(strict_types=1);

namespace RegexGenerator\CharacterClass;

class CharacterClassAny implements CharacterClassInterface
{
    private $delimiter;

    public function render(): string
    {
        return '.';
    }

    public function setDelimiter(string $delimiter): CharacterClassInterface
    {
        $this->delimiter = $delimiter;
        return $this;
    }
}