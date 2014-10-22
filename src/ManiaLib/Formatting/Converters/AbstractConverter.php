<?php

namespace ManiaLib\Formatting\Converters;

use ManiaLib\Formatting\ConverterInterface;
use ManiaLib\Formatting\Lexer;
use ManiaLib\Formatting\Style;

abstract class AbstractConverter implements ConverterInterface
{
    /**
     * @var Lexer
     */
    protected $lexer;

    /**
     * @var array
     */
    protected $stylesStack = array();

    /**
     * @var Style
     */
    protected $currentStyle;

    /**
     * @var bool
     */
    protected $links = false;

    /**
     * @var string
     */
    protected $result = '';

    public function __construct($string)
    {
        $this->lexer = new Lexer();
        $this->lexer->setInput($string);
    }

    public function getResult()
    {
        if (!$this->result) {
            $this->parseString();
        }
        return $this->result;
    }

    protected function parseString()
    {
        while ($this->lexer->moveNext()) {
            print_r($this->lexer->lookahead);
            switch ($this->lexer->lookahead['type']) {
                case Lexer::T_NONE:
                    break;
                case Lexer::T_ESCAPED_CHAR:
                    break;
                case Lexer::T_COLOR:
                    break;
                case Lexer::T_NO_COLOR:
                    break;
                case Lexer::T_SHADOWED:
                    break;
                case Lexer::T_BOLD:
                    break;
                case Lexer::T_ITALIC:
                    break;
                case Lexer::T_WIDE:
                    break;
                case Lexer::T_NARROW:
                    break;
                case Lexer::T_MEDIUM:
                    break;
                case Lexer::T_UPPERCASE:
                    break;
                case Lexer::T_RESET_ALL:
                    break;
                case Lexer::T_PUSH:
                    break;
                case Lexer::T_POP:
                    break;
                case Lexer::T_EXTERNAL_LINK:
                    break;
                case Lexer::T_EXTERNAL_HIDDEN_LINK:
                    break;
                case Lexer::T_INTERNAL_LINK:
                    break;
                case Lexer::T_INTERNAL_HIDDEN_LINK:
                    break;
                case Lexer::T_UNKNOWN_MARKUP:
                    break;
            }
        }
    }
}