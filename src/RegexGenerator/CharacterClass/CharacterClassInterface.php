<?php declare(strict_types=1);

namespace RegexGenerator\CharacterClass;

interface CharacterClassInterface
{
    public function render(): string;
    public function setDelimiter(string $delimiter): self;
}