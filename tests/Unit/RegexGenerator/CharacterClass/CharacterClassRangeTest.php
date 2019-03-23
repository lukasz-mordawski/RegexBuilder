<?php declare(strict_types=1);

namespace Tests\RegexGenerator\CharacterClass;

use PHPUnit\Framework\TestCase;
use RegexGenerator\CharacterClass\CharacterClassRange;

class CharacterClassRangeTest extends TestCase
{
    public function renderProvider()
    {
        return [
            [ 'a', 'z', '/', 'a-z' ],
            [ '0', '9', '#', '0-9' ],
            [ '/', '0', '/', '\\/-0' ],
            [ '0', '-', '/', '0-\\-' ]
        ];
    }

    /**
     * @dataProvider renderProvider
     */
    public function testRender(string $from, $to, $delimiter, $result)
    {
        $range = new CharacterClassRange($from, $to);
        $range->setDelimiter($delimiter);

        $this->assertSame($result, $range->render());
    }
}