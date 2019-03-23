<?php declare(strict_types=1);

namespace RegexGenerator\Node;

use Doctrine\Common\Collections\ArrayCollection;

interface NodeInterface
{
    public function addChild(NodeInterface $node): self;
    public function getChildren(): ArrayCollection;
    public function render(): string;
    public function setDelimiter(string $delimiter): self;
    public function setRepeatExact(int $number): self;
    public function setRepeatRange(int $min, ?int $max = null): self;
}