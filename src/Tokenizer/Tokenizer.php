<?php

declare(strict_types=1);

namespace Radki\TemplateEngine\Tokenizer;

class Tokenizer
{
    private const REGEX = '/
        # 
        (?<type> [a-z]+?)               # i
        (?<nullable> \??)               # ?
        (?<array> \[\])?                # []
        \:                              # :
        (?<name> [a-z_]+)               # name
        #
        /x';

    public function convertSqlToTokens(string $sql): array
    {
        $matchAny = preg_match_all(self::REGEX, $sql, $matches, \PREG_OFFSET_CAPTURE | PREG_SET_ORDER);
        if (!$matchAny) {
            return [$sql];
        }

        $stringStart = 0;
        $result = [];
        foreach ($matches as $matchArray) {
            $tokenStart = $matchArray[0][1];
            $tokenLength = strlen($matchArray[0][0]);

            $string = substr($sql, $stringStart, $tokenStart - $stringStart - 1);
            if ($string !== '') {
                $result[] = $string;
            }

            $result[] = $this->createTokenObject($matchArray);

            $stringStart = $tokenStart + $tokenLength + 1;
        }

        // Last string
        $string = substr($sql, $stringStart);
        if ($string !== '') {
            $result[] = $string;
        }

        return $result;
    }

    private function createTokenObject(array $matchArray): ParamToken
    {
        $isArray = ($matchArray['array'][0] !== '');
        $isNullable = ($matchArray['nullable'][0] !== '');
        return new ParamToken($matchArray['name'][0], $matchArray['type'][0], $isArray, $isNullable);
    }
}
