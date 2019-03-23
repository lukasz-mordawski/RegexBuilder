<?php declare(strict_types=1);

namespace Tests\RegexGenerator\Node;

use PHPUnit\Framework\TestCase;
use RegexGenerator\CharacterClass\CharacterClassDigits;
use RegexGenerator\Node\CharacterClassNode;

class CharacterClassNodeTest extends TestCase
{
    public function testRender_noRepeat()
    {
        $node = new CharacterClassNode(new CharacterClassDigits());
        $this->assertSame('\d', $node->render());
    }

    public function testRender_repeatExact()
    {
        $node = new CharacterClassNode(new CharacterClassDigits());
        $node->setRepeatExact(2);
        $this->assertSame('\d{2}', $node->render());
    }

    public function testRender_repeatRange()
    {
        $node = new CharacterClassNode(new CharacterClassDigits());
        $node->setRepeatRange(1);
        $this->assertSame('\d+', $node->render());
    }
}