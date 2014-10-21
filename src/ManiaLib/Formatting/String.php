<?php

namespace ManiaLib\Formatting;

class String implements StringInterface
{
    protected $string;

    public function __construct($string)
    {
        $this->string = $string;
    }

    public function __toString()
    {
        return $this->string;
    }

    public function contrastColors($backgroundColor)
    {
        $background = Color::StringToRgb24($backgroundColor);
        $result     = preg_replace_callback('/(?<!\$)((?:\$\$)*)(\$[0-9a-f]{1,3})/iu',
            function($matches) use ($background) {
            $color = Color::StringToRgb24($matches[2]);
            $color = Color::Contrast($color, $background);
            $color = Color::Rgb24ToRgb12($color);
            $color = Color::Rgb12ToString($color);
            return $matches[1].'$'.$color;
        }, $this->string);
        return $this;
    }

    public function strip($codes)
    {
        $linkCodes    = preg_grep('/hlp/iu', $codes);
        $colorCodes   = preg_grep('/[0-9a-f]/iu', $codes);
        $escapedChars = preg_grep('/[\$\[\]]/iu', $codes);
        $classicCodes = array_diff($codes, $linkCodes, $colorCodes, $escapedChars);

        $result = $this;
        if ($classicCodes) {
            $pattern = sprintf('/(?<!\$)((?:\$\$)*)\$[%s]/iu', implode('', $classicCodes));
            $result  = $result->setInput(preg_replace($pattern, '$1', $result));
        }
        if ($escapedChars) {
            $result = $result->setInput($result)->doStripEscapedChars($escapedChars);
        }
        if ($linkCodes) {
            $result = $result->setInput($result)->doStripLinks($linkCodes);
        }
        if ($colorCodes) {
            return $result->stripColors();
        } else {
            return $result;
        }
    }

    public function stripAll()
    {
        $result = preg_replace('/(?<!\$)((?:\$\$)*)\$[^$0-9a-hlp\[\]]/iu', '$1', $this->string);
        return $this->setInput($result)->doStripEscapedChars(array('$', '[', ']'))->stripLinks()->stripColors();
    }

    public function stripColors()
    {
        $result = preg_replace('/(?<!\$)((?:\$\$)*)\$(?:g|[0-9a-f][^\$]{0,2})/iu', '$1', $this->string);
        return $this->setInput($result);
    }

    public function stripLinks()
    {
        return $this->doStripLinks();
    }

    public function stripEscapeCharacters()
    {
        return (string) $this;
    }

    protected function doStripLinks(array $codes = array('h', 'l', 'p'))
    {
        $pattern = sprintf(
            '/(?<!\$)((?:\$\$)*)\$[%s](?:\[.*?\]|\[.*?$)?(.*?)(?:\$[%1$s]|(\$z)|$)/iu',
            implode('', $codes)
        );
        $result  = preg_replace($pattern, '$1$2$3', $this->string);
        return $this->setInput($result);
    }

    protected function doStripEscapedChars(array $codes = array('$', '[', ']'))
    {
        $pattern = sprintf('/\$([%s])/iu', addcslashes(implode('', $codes), '$[]'));
        $result  = preg_replace($pattern, '$1', $this->string);
        return $this->setInput($result);
    }
}