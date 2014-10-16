<?php

namespace ManiaLib\Formatting\Formatters;

class Lexer extends \Doctrine\Common\Lexer\AbstractLexer
{
    const T_NONE                 = 0;
    const T_DOLLAR               = 1;
    const T_ITALIC               = 2;
    const T_BOLD                 = 3;
    const T_SHADOWED             = 4;
    const T_WIDE                 = 5;
    const T_NARROW               = 6;
    const T_CAPITALIZED          = 7;
    const T_COLOR                = 8;
    const T_EXTERNAL_LINK        = 9;
    const T_EXTERNAL_HIDDEN_LINK = 10;
    const T_INTERNAL_LINK        = 11;
    const T_INTERNAL_HIDDEN_LINK = 12;
    const T_OPEN_STACK           = 13;
    const T_CLOSE_STACK          = 14;
    const T_RESET_WIDE           = 15;
    const T_RESET_COLOR          = 16;
    const T_RESET_STYLES         = 17;
    const T_OPEN_SQUARE_BRACKET  = 18;
    const T_CLOSE_SQUARE_BRACKET = 19;

    protected function getCatchablePatterns()
    {
        return array(
            '\$[hlp](\[[^\]]*\])|\$[hlp]',
            '\$[iozswnmtg\$<>\[\]]{1}',
            '\$[0-9a-f][^\$]{0,2}',
            '[^\$]*'
        );
    }

    protected function getNonCatchablePatterns()
    {
        return array('\$.{1}');
    }

    protected function getType(&$value)
    {
        $type = static::T_NONE;
        if (substr($value, 0, 1) == '$') {
            $style = strtolower(substr($value, 1));
            if (preg_match('/\$[0-9a-f]/iu', $value)) {
                return self::T_COLOR;
            } elseif (strlen($style) > 1) {
                if (substr($style, 0, 1) == 'h' || substr($style, 0, 1) == 'p') {
                    return static::T_INTERNAL_HIDDEN_LINK;
                } else {
                    return static::T_EXTERNAL_HIDDEN_LINK;
                }
            }
            switch ($style) {
                case 'i':
                    $type = static::T_ITALIC;
                    break;
                case 'o':
                    $type = static::T_BOLD;
                    break;
                case 's':
                    $type = static::T_SHADOWED;
                    break;
                case 'w':
                    $type = static::T_WIDE;
                    break;
                case 'n':
                    $type = static::T_NARROW;
                    break;
                case 'z':
                    $type = static::T_RESET_STYLES;
                    break;
                case 't':
                    $type = static::T_CAPITALIZED;
                    break;
                case 'g':
                    $type = static::T_RESET_COLOR;
                    break;
                case 'm':
                    $type = static::T_RESET_WIDE;
                    break;
                case '$':
                    $type = static::T_DOLLAR;
                    break;
                case 'p':
                case 'h':
                    $type = static::T_INTERNAL_LINK;
                    break;
                case 'l':
                    $type = static::T_EXTERNAL_LINK;
                    break;
                case '<':
                    $type = static::T_OPEN_STACK;
                    break;
                case '>':
                    $type = static::T_CLOSE_STACK;
                    break;
                case '[':
                    $type = static::T_OPEN_SQUARE_BRACKET;
                    break;
                case ']':
                    $type = static::T_CLOSE_SQUARE_BRACKET;
                    break;
            }
        }
        return $type;
    }
}