<?php

namespace ManiaLib\Formatting;

abstract class AbstractManiaplanetString implements ManiaplanetStringInterface
{
    /**
     * @var string
     */
    protected $input;

    public function __construct($input)
    {
        $this->input = $input;
    }

    public function __toString()
    {
        return $this->toString();
    }

    public function getInput()
    {
        return $this->input;
    }

    public function setInput($input)
    {
        $this->input = $input;
        return $this;
    }

    public function toString()
    {
        return $this->input;
    }
    
    /**
     * Remove codes provided from input string
     * if no code are provided all styles, colors and links will be stripped
     * @param string[] $codes
     * @return string
     */
    protected function doStrip(array $codes = array())
    {
        
    }

    /**
     * Remove every links from input string
     * @return string
     */
    protected function doStripLinks()
    {
        
    }

    /**
     * Remove every colors code from input string
     * Remove
     * @return string
     */
    protected function doStripColors()
    {
        
    }

    /**
     * Change string colors to increase contrast with backgroundColor
     * @param string $backgroundColor chaine au format RGB12 ou RGB24, i.e FFF ou FFFFFF
     * @return string
     */
    protected function doContrastColors($backgroundColor)
    {
        
    }
}