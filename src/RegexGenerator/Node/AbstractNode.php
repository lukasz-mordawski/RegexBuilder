<?php

namespace RegexGenerator\Node;

use Doctrine\Common\Collections\ArrayCollection;

abstract class AbstractNode implements NodeInterface
{
    protected $delimiter = '/';
    protected $repeat = '';
    protected $children;

    public function setRepeatExact(int $number): NodeInterface
    {
        $this->repeat = '{' . $number . '}';
        return $this;
    }

    public function setRepeatRange(?int $min, ?int $max = null): NodeInterface
    {
        if ($min === null && $max === null) {
            throw new \InvalidArgumentException('Either min or max must not be null.');
        }

        if ($min === 1 && $max === null) {
            $this->repeat = '+';
        } elseif ($min === 0 && $max === null) {
            $this->repeat = '*';
        } elseif ($min === 0 && $max === 1) {
            $this->repeat = '?';
        } else {
            $this->repeat = '{' . $min . ',' . $max . '}';
        }

        return $this;
    }

    public function setDelimiter(string $delimiter): NodeInterface
    {
        $this->delimiter = $delimiter;
        return $this;
    }

    public function addChild(NodeInterface $node): NodeInterface
    {
        return $this;
    }

    public function getChildren(): ArrayCollection
    {
        return $this->children;
    }

    public function __toString(): string
    {
        return $this->render();
    }
}