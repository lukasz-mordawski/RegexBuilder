<?php declare(strict_types=1);

namespace Tests\RegexGenerator;

use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\TestCase;
use RegexGenerator\Modifier\ModifierInterface;
use RegexGenerator\Node\NodeInterface;
use RegexGenerator\Node\PlainTextNode;
use RegexGenerator\RegularExpression;

class RegularExpressionTest extends TestCase
{
    public function testAddChild(): void
    {
        $delimiter = '/';
        $child = $this->getMockBuilder(NodeInterface::class)
            ->getMockForAbstractClass();

        $child->expects($this->once())
            ->method('setDelimiter')
            ->with($delimiter);

        $regex = new RegularExpression($delimiter);
        $regex->addChild($child);

        $children = $regex->getChildren();
        $this->assertInstanceOf(ArrayCollection::class, $children);
        $this->assertCount(1, $children);
        $this->assertSame($child, $children->get(0));
    }

    public function testAddModifier(): void
    {
        $modifier = $this->getMockBuilder(ModifierInterface::class)
            ->getMockForAbstractClass();

        $regex = new RegularExpression('/');
        $regex->addModifier($modifier);
        $modifiers = $regex->getModifiers();

        $this->assertInstanceOf(ArrayCollection::class, $modifiers);
        $this->assertCount(1, $modifiers);
        $this->assertSame($modifier, $modifiers->get(0));
    }

    public function testRender_withoutChildren(): void
    {
        $regex = new RegularExpression('/');
        $this->assertSame('//', $regex->render());
    }

    public function beginningEndProvider(): array
    {
        return [
            [ false, false, '/test/' ],
            [ true, false, '/^test/' ],
            [ false, true, '/test$/' ],
            [ true, true, '/^test$/' ],
        ];
    }

    /**
     * @dataProvider beginningEndProvider
     */
    public function testRender_BeginningEnd(bool $begin, bool $end, string $expected): void
    {
        $regex = new RegularExpression('/');
        $regex->addChild(new PlainTextNode('test'));
        $regex->setBeginning($begin);
        $regex->setEnd($end);

        $this->assertSame($expected, $regex->render());
    }

    public function testRender_withChildrenAndModifiers(): void
    {
        $regex = new RegularExpression('/');
        $child = $this->getMockBuilder(NodeInterface::class)
            ->getMockForAbstractClass();

        $child->expects($this->exactly(2))
            ->method('render')
            ->will($this->onConsecutiveCalls(
                'foo', 'bar'
            ));

        $modifier = $this->getMockBuilder(ModifierInterface::class)
            ->getMockForAbstractClass();

        $modifier->expects($this->exactly(2))
            ->method('render')
            ->will($this->onConsecutiveCalls(
                'i', 'g'
            ));

        $regex->addChild($child);
        $regex->addChild($child);
        $regex->addModifier($modifier);
        $regex->addModifier($modifier);

        $this->assertSame('/foobar/ig', $regex->render());
    }
}