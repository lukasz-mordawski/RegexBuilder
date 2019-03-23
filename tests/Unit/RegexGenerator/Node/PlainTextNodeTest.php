<?php declare(strict_types=1);

namespace Tests\RegexGenerator\Node;

use PHPUnit\Framework\TestCase;
use RegexGenerator\Node\NodeInterface;
use RegexGenerator\Node\PlainTextNode;

class PlainTextNodeTest extends TestCase
{
    public function renderProvider(): array
    {
        return [
            [ 't', '/', 't' ],
            [ 'test', '/', 'test' ],
            [ 'te/st/', '/', 'te\/st\/'],
            [ 'te/st/', '#', 'te/st/'],
            [ 'te##s/t', '#', 'te\#\#s/t']
        ];
    }

    /**
     * @dataProvider renderProvider
     */
    public function testRender_NodeIsRenderedProperly($word, $delimiter, $regex): void
    {
        $node = new PlainTextNode($word, $delimiter);
        $this->assertSame($regex, $node->render());
    }

    /**
     * @dataProvider renderProvider
     */
    public function testToString_nodeIsRenderedProperly($word, $delimiter, $regex): void
    {
        $node = new PlainTextNode($word, $delimiter);
        $this->assertSame($regex, $node->__toString());
    }

    public function testAddChild_ChildIsNotAdded(): void
    {
        $child = $this->getMockBuilder(NodeInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $node = new PlainTextNode('test');
        $node->addChild($child);
        $this->assertSame(0, $node->getChildren()->count());
    }

    public function testSetDelimiter(): void
    {
        $node = new PlainTextNode('t/e#st', '/');
        $node->setDelimiter('#');

        $this->assertSame('t/e\#st', $node->render());
    }

    public function testSetRepeatExact(): void
    {
        $node = new PlainTextNode('t');
        $node->setRepeatExact(3);
        $this->assertSame('t{3}', $node->render());
    }

    public function testRepeatRange_BothArgumentNull_ThrowInvalidArgumentException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $node = new PlainTextNode('t');
        $node->setRepeatRange(null, null);
    }

    public function repeatRangeProvider(): array
    {
        return [
            [ 0, 1, 't?' ],
            [ 1, 5, 't{1,5}'],
            [ 0, null, 't*'],
            [ 1, null, 't+'],
            [ null, 4, 't{,4}']
        ];
    }

    /**
     * @dataProvider repeatRangeProvider
     */
    public function testRepeatRange(?int $min, ?int $max = null, string $result): void
    {
        $node = new PlainTextNode('t');
        $node->setRepeatRange($min, $max);

        $this->assertSame($result, $node->render());
    }
}