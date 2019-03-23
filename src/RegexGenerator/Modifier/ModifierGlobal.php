<?php

namespace RegexGenerator\Modifier;

class ModifierGlobal implements ModifierInterface
{
    public function render(): string
    {
        return 'g';
    }

    public function __toString(): string
    {
        return $this->render();
    }
}