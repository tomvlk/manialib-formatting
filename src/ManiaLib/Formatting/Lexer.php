<?php

namespace ManiaLib\Formatting;

class Lexer extends \Doctrine\Common\Lexer\AbstractLexer
{
    protected function getCatchablePatterns()
    {
        return array(
            '\$[hlp](\[[^\]]*\])',
            '\$[0-9a-f][^\$]{0,2}',
            '\$.',
            '[^\$]*'
        );
    }

    protected function getNonCatchablePatterns()
    {
        return array();
    }

    protected function getType(&$value)
    {

    }
}