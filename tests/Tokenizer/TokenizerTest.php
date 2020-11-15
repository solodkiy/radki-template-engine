<?php

declare(strict_types=1);

namespace Radki\TemplateEngine\Tests\Tokenizer;

use Radki\TemplateEngine\Tokenizer\ParamToken;
use Radki\TemplateEngine\Tokenizer\Tokenizer;
use PHPUnit\Framework\TestCase;

class TokenizerTest extends TestCase
{
    /**
     * @param string $sql
     * @param array $expectedResult
     * @dataProvider providerConvertSqlToTokens
     */
    public function testConvertSqlToTokens(string $sql, array $expectedResult)
    {
        $tokenizer = new Tokenizer();
        $this->assertEquals($expectedResult, $tokenizer->convertSqlToTokens($sql));
    }

    public function providerConvertSqlToTokens(): array
    {
        return [
            [
                'SELECT * FROM #t:table# WHERE user_id IN(#i[]:ids#) AND salary > #i?:salary#',
                [
                    'SELECT * FROM ',
                    new ParamToken('table', 't'),
                    ' WHERE user_id IN(',
                    new ParamToken('ids', 'i', true),
                    ') AND salary > ',
                    new ParamToken('salary', 'i', false, true),
                ]
            ],
            [
                '#t:table#',
                [
                    new ParamToken('table', 't'),
                ]
            ],
            [
                '#t:a##t:b#',
                [
                    new ParamToken('a', 't'),
                    new ParamToken('b', 't'),
                ]
            ],
            [
                'SELECT id FROM table',
                [
                    'SELECT id FROM table',
                ]
            ],
            [
                'SELECT id FROM table WHERE #r:one##r:two# AND x=1',
                [
                    'SELECT id FROM table WHERE ',
                    new ParamToken('one', 'r'),
                    new ParamToken('two', 'r'),
                    ' AND x=1'
                ]
            ],
            [
                'SELECT id FROM table WHERE #r:one# # This comment continues to the end of line',
                [
                    'SELECT id FROM table WHERE ',
                    new ParamToken('one', 'r'),
                    ' # This comment continues to the end of line'
                ]
            ],
        ];
    }
}
