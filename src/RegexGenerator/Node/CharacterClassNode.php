<?php declare(strict_types=1);

namespace RegexGenerator\Node;

use Doctrine\Common\Collections\ArrayCollection;
use RegexGenerator\CharacterClass\CharacterClassInterface;

class CharacterClassNode extends AbstractNode implements NodeInterface
{
    private $characters;

    public function __construct(CharacterClassInterface $characters)
    {
        $this->characters = $characters;
        $this->children = new ArrayCollection();
    }

    public function render(): string
    {
        return $this->characters->render() . $this->repeat;
    }
}