<?php declare(strict_types=1);

namespace RegexGenerator\Node;

use Doctrine\Common\Collections\ArrayCollection;
use RegexGenerator\CharacterClass\CharacterClassInterface;
use RegexGenerator\Node\AbstractNode;
use RegexGenerator\Node\NodeInterface;

class GroupNode extends AbstractNode implements NodeInterface
{
    public function __construct()
    {
        $this->children = new ArrayCollection();
    }

    public function addChild(NodeInterface $child): NodeInterface
    {
        $this->children->add($child);
        return $this;
    }

    public function getChildren(): ArrayCollection
    {
        return $this->children;
    }

    public function render(): string
    {
        $chars = '';

        /** @var CharacterClassInterface $character */
        foreach ($this->children as $character) {
            $character->setDelimiter($this->delimiter);
            $chars .= $character->render();
        }
        return '(' . $chars . ')' . $this->repeat;
    }
}