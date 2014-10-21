<?php

namespace ManiaLib\Formatting;

class Lexer extends \Doctrine\Common\Lexer\AbstractLexer
{
    //No Style
    const T_NONE = 0;
    // Escaped charaters
    const T_DOLLAR_CHAR = 1;
    const T_SQUARE_BRACKET_OPENING_CHAR = 2;
    const T_SQUARE_BRACKET_CLOSING_CHAR = 3;
    //Modifiers
    const T_COLOR = 4;
    const T_NO_COLOR = 5;
    const T_SHADOWED = 6;
    const T_BOLD = 7;
    const T_ITALIC = 8;
    const T_WIDE = 9;
    const T_NARROW = 10;
    const T_MEDIUM = 11;
    const T_UPPERCASE = 12;
    const T_RESET_ALL = 13;
    const T_PUSH = 14;
    const T_POP = 15;
    //Links
    const T_EXTERNAL_LINK = 11;
    const T_EXTERNAL_HIDDEN_LINK = 12;
    const T_INTERNAL_LINK = 13;
    const T_INTERNAL_HIDDEN_LINK = 14;
    //Other markups
    const T_UNKNOWN_MARKUP = 20;

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