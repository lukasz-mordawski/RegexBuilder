<?php declare(strict_types=1);

namespace RegexGenerator\Modifier;

interface ModifierInterface
{
    public function render(): string;
    public function __toString(): string;
}