<?php

namespace ManiaLib\Formatting;

class Style
{
    protected $bold = false;
    protected $italic = false;
    protected $shadowed = false;
    protected $width = 1;
    protected $uppercase = false;
    protected $color;

    function isBold()
    {
        return $this->bold;
    }

    function isItalic()
    {
        return $this->italic;
    }

    public function isShadowed()
    {
        return $this->shadowed;
    }

    public function getWidth()
    {
        return $this->width;
    }

    function isUppercase()
    {
        return $this->uppercase;
    }

    function getColor()
    {
        return $this->color;
    }

    function setBold($bold)
    {
        $this->bold = $bold;
    }

    function setItalic($italic)
    {
        $this->italic = $italic;
    }

    public function setShadowed($shadowed)
    {
        $this->shadowed = $shadowed;
    }

    public function setWidth($width)
    {
        $this->width = $width;
    }

    function setUppercase($uppercase)
    {
        $this->uppercase = $uppercase;
    }

    function setColor($color)
    {
        $this->color = $color;
    }
}