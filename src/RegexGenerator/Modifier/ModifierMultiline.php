<?php

namespace RegexGenerator\Modifier;

class ModifierMultiline implements ModifierInterface
{
    public function render(): string
    {
        return 'm';
    }

    public function __toString(): string
    {
        return $this->render();
    }
}