<?php

namespace ManiaLib\Formatting;

class ManiaplanetString implements ManiaplanetStringInterface
{
    protected $input;

    public function __construct($input)
    {
        $this->input = $input;
    }

    public function __toString()
    {
        return $this->getInput();
    }

    public function getInput()
    {
        return $this->input;
    }

    public function setInput($input)
    {
        return new static($input);
    }

    public function contrastColors($backgroundColor)
    {
        $background = Color::StringToRgb24($backgroundColor);
        $result = preg_replace_callback('/(?<!\$)((?:\$\$)*)(\$[0-9a-f]{1,3})/iu',
            function($matches) use ($background) {
            $color = Color::StringToRgb24($matches[2]);
            $color = Color::Contrast($color, $background);
            $color = Color::Rgb24ToRgb12($color);
            $color = Color::Rgb12ToString($color);
            return $matches[1].'$'.$color;
        }, $this->input);
        return $this->setInput($result);
    }

    public function strip(array $codes)
    {
        $linkCodes = preg_grep('/hlp/iu', $codes);
        $colorCodes = preg_grep('/[0-9a-f]/iu', $codes);
        $escapedChar = preg_grep('/[\$\[\]]/iu', $codes);
        $classicCodes = array_diff($codes, $linkCodes, $colorCodes, $escapedChar);
        $string = $this->input;
        if($classicCodes) {
            $string = preg_replace(sprintf('/(?<!\$)((?:\$\$)*)\$[%s]/iu', implode('', $classicCodes)), '$1', $string);
        }
        if($escapedChar) {
            $string = preg_replace('/\$([\$\[\]])/iu', '$1', $string);
        }
        if($linkCodes) {
            $pattern = sprintf('/(?<!\$)((?:\$\$)*)\$[%s](?:\[.*?\]|\[.*?$)?(.*?)(?:\$[%s]|(\$z)|$)/iu', implode('', $linkCodes));
            $string = preg_replace($pattern, '$1$2$3', $string);
        }
        $result = $this->setInput($string);
        if($colorCodes) {
            return $result->stripColors();
        } else {
            return $result;
        }
    }

    public function stripAll()
    {
        $string = preg_replace('/(?<!\$)((?:\$\$)*)\$[^$0-9a-hlp\[\]]/iu', '$1', $this->input);
        $result = preg_replace('/\$([\$\[\]])/iu', '$1', $string);
		return $this->setInput($result)->stripLinks()->stripColors();
    }

    public function stripColors()
    {
        $result = preg_replace('/(?<!\$)((?:\$\$)*)\$(?:g|[0-9a-f]{1,3})/iu', '$1', $this->input);
        return $this->setInput($result);
    }

    public function stripLinks()
    {
        $result = preg_replace('/(?<!\$)((?:\$\$)*)\$[hlp](?:\[.*?\]|\[.*?$)?(.*?)(?:\$[hlp]|(\$z)|$)/iu', '$1$2$3', $this->input);
        return $this->setInput($result);
    }

    public function toString()
    {
        return (string)$this;
    }
}