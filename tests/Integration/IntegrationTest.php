<?php declare(strict_types=1);

namespace Tests\Integration;

use RegexGenerator\CharacterClass\CharacterClassAny;
use RegexGenerator\CharacterClass\CharacterClassExactCharacters;
use RegexGenerator\CharacterClass\CharacterClassRange;
use RegexGenerator\Modifier\ModifierCaseInsensitive;
use RegexGenerator\Modifier\ModifierGlobal;
use RegexGenerator\Modifier\ModifierMultiline;
use RegexGenerator\Node\CharacterClassNode;
use RegexGenerator\Node\CharacterRangeNode;
use RegexGenerator\Node\GroupNode;
use RegexGenerator\Node\PlainTextNode;
use RegexGenerator\RegularExpression;

class IntegrationTest extends \PHPUnit\Framework\TestCase
{
    public function regularExpressionProvider()
    {
        return $this->getRegularExpressionsWithResults();
    }

    /**
     * @dataProvider regularExpressionProvider
     */
    public function testRegularExpressions(RegularExpression $regex, string $regexResult)
    {
        $this->assertSame($regexResult, $regex->render());
    }

    public function getRegularExpressionsWithResults()
    {
        $regexResult1 = '/^(stop)+/i';
        $regex1 = new RegularExpression('/');

        $regex1->setBeginning(true);

        $modifier = new ModifierCaseInsensitive();
        $group = new GroupNode();
        $regex1->addChild($group);
        $regex1->addModifier($modifier);

        $group->setRepeatRange(1);
        $group->addChild(new PlainTextNode('stop'));

        $regexResult2 = '#([a-zA-Z0-9/]+)_.*_[0-9]{1,3}$#gm';
        $regex2 = new RegularExpression('#');
        $regex2->addModifier(new ModifierGlobal());
        $regex2->addModifier(new ModifierMultiline());

        $group = new GroupNode();
        $regex2->addChild($group);

        $range = new CharacterRangeNode();
        $range->addCharacters(new CharacterClassRange('a', 'z'));
        $range->addCharacters(new CharacterClassRange('A', 'Z'));
        $range->addCharacters(new CharacterClassRange('0', '9'));
        $range->addCharacters(new CharacterClassExactCharacters('/'));
        $range->setRepeatRange(1);
        $group->addChild($range);

        $regex2->addChild(new PlainTextNode('_'));

        $child = new CharacterClassNode(new CharacterClassAny());
        $child->setRepeatRange(0);
        $regex2->addChild($child);

        $regex2->addChild(new PlainTextNode('_'));

        $range = new CharacterRangeNode();
        $range->addCharacters(new CharacterClassRange('0', '9'));
        $range->setRepeatRange(1,3);
        $regex2->addChild($range);

        $regex2->setEnd(true);

        return [
            [ $regex1, $regexResult1 ],
            [ $regex2, $regexResult2 ]
        ];
    }
}