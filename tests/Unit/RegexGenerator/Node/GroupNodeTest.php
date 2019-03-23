<?php declare(strict_types=1);

namespace Tests\RegexGenerator\Node;

use PHPUnit\Framework\TestCase;
use RegexGenerator\CharacterClass\CharacterClassRange;
use RegexGenerator\Node\CharacterRangeNode;
use RegexGenerator\Node\GroupNode;
use RegexGenerator\Node\NodeInterface;
use RegexGenerator\Node\PlainTextNode;

class GroupNodeTest extends TestCase
{
    public function renderProvider(): array
    {
        return [
            # set #1
            [
                # childNodes
                [ new PlainTextNode('test'), (new CharacterRangeNode())->addCharacters(new CharacterClassRange('a', 'z'))->setRepeatExact(2) ],
                # delimiter
                '/',
                # regex
                '(test[a-z]{2})'
            ]
        ];
    }

    /**
     * @dataProvider renderProvider
     */
    public function testRender_NodeIsRenderedProperly(array $childNodes, $delimiter, $regex): void
    {
        $node = new GroupNode();
        foreach ($childNodes as $childNode) {
            $node->addChild($childNode);
        }
        $node->setDelimiter($delimiter);
        $this->assertSame($regex, $node->render());
    }

    /**
     * @dataProvider renderProvider
     */
    public function testToString_nodeIsRenderedProperly(array $childNodes, $delimiter, $regex): void
    {
        $node = new GroupNode();
        foreach ($childNodes as $childNode) {
            $node->addChild($childNode);
        }
        $node->setDelimiter($delimiter);
        $this->assertSame($regex, $node->render());
    }

    public function testAddChild_ChildIsNotAdded(): void
    {
        $child = $this->getMockBuilder(NodeInterface::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $node = new GroupNode();
        $node->addChild($child);
        $this->assertSame(1, $node->getChildren()->count());
        $this->assertSame($child, $node->getChildren()->get(0));
    }

    public function testSetDelimiter(): void
    {
        $node = new GroupNode();
        $node->addChild(new PlainTextNode('t/e#st'));
        $node->setDelimiter('#');

        $this->assertSame('(t/e\#st)', $node->render());
    }

    public function testSetRepeatExact(): void
    {
        $node = new GroupNode();
        $node->addChild(new PlainTextNode('t'));
        $node->setRepeatExact(3);
        $this->assertSame('(t){3}', $node->render());
    }

    public function testRepeatRange_BothArgumentNull_ThrowInvalidArgumentException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $node = new CharacterRangeNode();
        $node->setRepeatRange(null, null);
    }

    public function repeatRangeProvider(): array
    {
        return [
            [ 0, 1, '(s)?' ],
            [ 1, 5, '(s){1,5}'],
            [ 0, null, '(s)*'],
            [ 1, null, '(s)+'],
            [ null, 4, '(s){,4}']
        ];
    }

    /**
     * @dataProvider repeatRangeProvider
     */
    public function testRepeatRange(?int $min, ?int $max = null, string $result): void
    {
        $node = new GroupNode();
        $node->addChild(new PlainTextNode('s'));
        $node->setRepeatRange($min, $max);

        $this->assertSame($result, $node->render());
    }
}