<?php

namespace ManiaLib\Formatting;

class ManiaplanetStringMutable extends AbstractManiaplanetString
{
    /**
     * @var string
     */
    protected $originalString;

    public function __construct($input)
    {
        parent::__construct($input);
        $this->originalString = $input;
    }

    public function contrastColors($backgroundColor)
    {
        $this->input = $this->doContrastColors($backgroundColor);
        return $this;
    }

    public function setInput($input)
    {
        parent::setInput($input);
        $this->originalString = $input;
        return $this;
    }

    public function strip(string $codes = array())
    {
        $this->input = $this->doStrip($codes);
        return $this;
    }

    public function stripColors()
    {
        $this->input = $this->doStripColors();
        return $this;
    }

    public function stripLinks()
    {
        $this->input = $this->doStripLinks();
        return $this;
    }

    /**
     * Restore the current formatted string to the input string
     *
     * @return static
     */
    public function restore()
    {
        $this->input = $this->originalString;
    }
}