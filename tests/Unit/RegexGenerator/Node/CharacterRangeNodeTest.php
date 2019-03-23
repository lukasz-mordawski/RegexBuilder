<?php declare(strict_types=1);

namespace Tests\RegexGenerator\Node;

use PHPUnit\Framework\TestCase;
use RegexGenerator\CharacterClass\CharacterClassDigits;
use RegexGenerator\CharacterClass\CharacterClassExactCharacters;
use RegexGenerator\CharacterClass\CharacterClassRange;
use RegexGenerator\CharacterClass\CharacterClassWhitespaces;
use RegexGenerator\CharacterClass\CharacterClassWord;
use RegexGenerator\Node\CharacterRangeNode;
use RegexGenerator\Node\NodeInterface;

class CharacterRangeNodeTest extends TestCase
{
    public function renderProvider(): array
    {
        return [
            # set 1
            [
                // $characters
                [ new CharacterClassDigits(), new CharacterClassRange('a', 'z'), new CharacterClassRange('A', 'Z') ],
                // $delimiter
                '/',
                // $negated
                false,
                // $regex
                '[\da-zA-Z]'
            ],
            # set 2
            [
                // $characters
                [ new CharacterClassDigits(), new CharacterClassRange('a', 'z'), new CharacterClassRange('A', 'Z') ],
                // $delimiter
                '/',
                // $negated
                true,
                // $regex
                '[^\da-zA-Z]'
            ],
            # set 3
            [
                // $characters
                [ new CharacterClassExactCharacters('/'), new CharacterClassRange('a', 'z'), new CharacterClassRange('A', 'Z') ],
                // $delimiter
                '/',
                // $negated
                true,
                // $regex
                '[^\/a-zA-Z]'
            ],
            # set 4
            [
                // $characters
                [ new CharacterClassExactCharacters('/'), new CharacterClassRange('a', 'z'), new CharacterClassRange('A', 'Z') ],
                // $delimiter
                '#',
                // $negated
                true,
                // $regex
                '[^/a-zA-Z]'
            ]
        ];
    }

    /**
     * @dataProvider renderProvider
     */
    public function testRender_NodeIsRenderedProperly(array $characters, $delimiter, $negated, $regex): void
    {
        $node = new CharacterRangeNode();
        foreach ($characters as $chars) {
            $node->addCharacters($chars);
        }
        $node->setNegated($negated)
            ->setDelimiter($delimiter);
        $this->assertSame($regex, $node->render());
    }

    /**
     * @dataProvider renderProvider
     */
    public function testToString_nodeIsRenderedProperly(array $characters, $delimiter, $negated, $regex): void
    {
        $node = new CharacterRangeNode();
        foreach ($characters as $chars) {
            $node->addCharacters($chars);
        }
        $node->setNegated($negated)
            ->setDelimiter($delimiter);
        $this->assertSame($regex, $node->__toString());
    }

    public function testRender_RepeatRange(): void
    {
        $node = new CharacterRangeNode();
        $node->addCharacters(new CharacterClassDigits());
        $node->setRepeatExact(3);

        $this->assertSame('[\d]{3}', $node->render());
    }

    public function testAddChild_ChildIsNotAdded(): void
    {
        $child = $this->getMockBuilder(NodeInterface::class)
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $node = new CharacterRangeNode();
        $node->addChild($child);
        $this->assertSame(0, $node->getChildren()->count());
    }

    public function testSetDelimiter(): void
    {
        $node = new CharacterRangeNode();
        $node->addCharacters(new CharacterClassExactCharacters('t/e#st'));
        $node->setDelimiter('#');

        $this->assertSame('[t/e\#st]', $node->render());
    }

    public function testSetRepeatExact(): void
    {
        $node = new CharacterRangeNode();
        $node->addCharacters(new CharacterClassWhitespaces());
        $node->setRepeatExact(3);
        $this->assertSame('[\s]{3}', $node->render());
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
            [ 0, 1, '[\w]?' ],
            [ 1, 5, '[\w]{1,5}'],
            [ 0, null, '[\w]*'],
            [ 1, null, '[\w]+'],
            [ null, 4, '[\w]{,4}']
        ];
    }

    /**
     * @dataProvider repeatRangeProvider
     */
    public function testRepeatRange(?int $min, ?int $max = null, string $result): void
    {
        $node = new CharacterRangeNode();
        $node->addCharacters(new CharacterClassWord());
        $node->setRepeatRange($min, $max);

        $this->assertSame($result, $node->render());
    }
}