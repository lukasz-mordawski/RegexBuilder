<?php declare(strict_types=1);

namespace RegexGenerator\CharacterClass;

class CharacterClassRange implements CharacterClassInterface
{
    private $delimiter;
    private $from;
    private $to;

    public function __construct(string $from, string $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function setDelimiter(string $delimiter): CharacterClassInterface
    {
        $this->delimiter = $delimiter;
        return $this;
    }

    public function render(): string
    {
        return sprintf('%s-%s',
            preg_quote($this->from, '/'),
            preg_quote($this->to, '/')
        );
    }
}