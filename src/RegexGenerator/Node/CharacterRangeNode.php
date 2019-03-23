<?php declare(strict_types=1);

namespace RegexGenerator\Node;

use Doctrine\Common\Collections\ArrayCollection;
use RegexGenerator\CharacterClass\CharacterClassInterface;

class CharacterRangeNode extends AbstractNode implements NodeInterface
{
    private $negated = '';
    private $characters;

    public function __construct()
    {
        $this->characters = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    public function addCharacters(CharacterClassInterface $characters): NodeInterface
    {
        $this->characters->add($characters);
        return $this;
    }

    public function getCharacters()
    {
        return $this->characters;
    }

    public function render(): string
    {
        $chars = '';

        /** @var CharacterClassInterface $character */
        foreach ($this->characters as $character) {
            $character->setDelimiter($this->delimiter);
            $chars .= $character->render();
        }
        return '[' . $this->negated . $chars . ']' . $this->repeat;
    }

    public function setNegated(bool $flag): self
    {
        $this->negated = $flag ? '^' : '';
        return $this;
    }
}