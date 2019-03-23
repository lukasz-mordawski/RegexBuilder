<?php declare(strict_types=1);

namespace RegexGenerator;

use Doctrine\Common\Collections\ArrayCollection;
use RegexGenerator\Modifier\ModifierInterface;
use RegexGenerator\Node\NodeInterface;

class RegularExpression
{
    private $children;
    private $modifiers;
    private $delimiter;
    private $beginning = '';
    private $end = '';

    public function __construct(string $delimiter)
    {
        $this->delimiter = $delimiter;
        $this->children = new ArrayCollection();
        $this->modifiers = new ArrayCollection();
    }

    public function addChild(NodeInterface $node): self
    {
        $node->setDelimiter($this->delimiter);
        $this->children->add($node);
        return $this;
    }

    public function getChildren(): ArrayCollection
    {
        return $this->children;
    }

    public function render(): string
    {
        $regex = '';
        $regex .= $this->delimiter;
        $regex .= $this->beginning;

        foreach ($this->children as $child) {
            $regex .= $child->render();
        }

        $regex .= $this->end;
        $regex .= $this->delimiter;

        foreach ($this->modifiers as $modifier) {
            $regex .= $modifier->render();
        }

        return $regex;
    }

    public function __toString(): string
    {
        return $this->render();
    }

    public function addModifier(ModifierInterface $modifier): self
    {
        $this->modifiers->add($modifier);
        return $this;
    }

    public function getModifiers(): ArrayCollection
    {
        return $this->modifiers;
    }

    public function setBeginning(bool $flag): self
    {
        if ($flag) {
            $this->beginning = '^';
        } else {
            $this->beginning = '';
        }

        return $this;
    }

    public function setEnd(bool $flag): self
    {
        if ($flag) {
            $this->end = '$';
        } else {
            $this->end = '';
        }

        return $this;
    }
}