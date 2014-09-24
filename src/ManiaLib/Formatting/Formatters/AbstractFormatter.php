<?php

namespace ManiaLib\Formatting\Formatters;

use ManiaLib\Formatting\ManiaplanetStringInterface;

abstract class AbstractFormatter
{
    protected $lexer;

    /**
     * @var ManiaplanetStringInterface
     */
    protected $string;

    public function __construct(ManiaplanetStringInterface $string)
    {
        $this->string = $string;
        $this->lexer = new Lexer();
    }

    public abstract function getFormattedString();
}