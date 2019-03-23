<?php

namespace RegexGenerator\Modifier;

class ModifierCaseInsensitive implements ModifierInterface
{
    public function render(): string
    {
        return 'i';
    }

    public function __toString(): string
    {
        return $this->render();
    }
}