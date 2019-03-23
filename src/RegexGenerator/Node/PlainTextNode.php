<?php declare(strict_types=1);

namespace RegexGenerator\Node;

use Doctrine\Common\Collections\ArrayCollection;

class PlainTextNode extends AbstractNode implements NodeInterface
{
    private $content;

    public function __construct(string $content, string $delimiter = '/')
    {
        $this->content = $content;
        $this->delimiter = $delimiter;
        $this->children = new ArrayCollection();
    }

    public function render(): string
    {
        $content = $this->content;
        $content = preg_quote($content, $this->delimiter);

        $content .= $this->repeat;

        return $content;
    }
}