<?php declare(strict_types=1);

namespace Tests\RegexGenerator\CharacterClass;

use PHPUnit\Framework\TestCase;
use RegexGenerator\CharacterClass\CharacterClassExactCharacters;

class CharacterClassExactCharactersTest extends TestCase
{
    public function renderProvider(): array
    {
        return [
            [ 'a', '/', 'a' ],
            [ 'a-c', '/', 'a\\-c'],
            [ 'a/c', '/', 'a\\/c'],
            [ 'a#c', '#', 'a\\#c'],
            [ 'a#c', '/', 'a#c']
        ];
    }

    /**
     * @dataProvider renderProvider
     */
    public function testRender(string $characters, string $delimiter, string $result)
    {
        $class = new CharacterClassExactCharacters($characters);
        $class->setDelimiter($delimiter);

        $this->assertSame($result, $class->render());
    }
}