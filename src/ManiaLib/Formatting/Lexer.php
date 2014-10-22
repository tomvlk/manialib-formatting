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
        $type = static::T_NONE;
        if (substr($value, 0, 1) == '$') {
            $value = substr($value, 1);
            $style = strtolower($value);
            if (preg_match('/^[0-9a-f]/iu', $style)) {
                $type = static::T_COLOR;
            } elseif (strlen($style) > 1) {
                if (preg_match('/^[hp]/iu', $style)) {
                    $type = static::T_INTERNAL_HIDDEN_LINK;
                } else {
                    $type = static::T_EXTERNAL_HIDDEN_LINK;
                }
            } else {
                switch ($style) {
                    case '$': $type = static::T_DOLLAR_CHAR;
                        break;
                    case '[': $type = static::T_SQUARE_BRACKET_OPENING_CHAR;
                        break;
                    case ']': $type = static::T_SQUARE_BRACKET_CLOSING_CHAR;
                        break;
                    case 'g': $type = static::T_NO_COLOR;
                        break;
                    case 's': $type = static::T_SHADOWED;
                        break;
                    case 'b': $type = static::T_BOLD;
                        break;
                    case 'i': $type = static::T_ITALIC;
                        break;
                    case 'w': $type = static::T_WIDE;
                        break;
                    case 'n': $type = static::T_NARROW;
                        break;
                    case 'm': $type = static::T_MEDIUM;
                        break;
                    case 't': $type = static::T_UPPERCASE;
                        break;
                    case 'z': $type = static::T_RESET_ALL;
                        break;
                    case '<': $type = static::T_PUSH;
                        break;
                    case '>': $type = static::T_POP;
                        break;
                    case 'h':
                        //nobreak
                    case 'p': $type = static::T_INTERNAL_LINK;
                        break;
                    case 'l': $type = static::T_EXTERNAL_LINK;
                        break;
                    default:
                        $type = static::T_UNKNOWN_MARKUP;
                }
            }
        }
        return $type;
    }
}