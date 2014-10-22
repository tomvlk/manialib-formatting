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
        $this->string = preg_replace_callback('/(?<!\$)((?:\$[\$])*)(\$[0-9a-f][^\$]{0,2})/iu',
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
        $linkCodes = array();
        preg_match_all('/[hlp]/iu', $codes, $linkCodes);
        $colorCodes = array();
        preg_match_all('/[0-9a-f]/iu', $codes, $colorCodes);
        $escapedChars = array();
        preg_match_all('/[\$\[\]]/iu', $codes, $escapedChars);

        if (count($linkCodes[0])) {
            $this->string = $this->doStripLinks(array_unique($linkCodes[0]));
        }
        if(count($colorCodes[0])) {
           $this->string = $this->stripColors();
        }
        $this->string = sprintf('/(?<!\$)((?:\$[\$\[\]])*)\$[%s]/iu', $codes);
        if(count($escapedChars[0])) {
            $this->string = $this->doStripEscapedChars(array_unique($escapedChars[0]));
        }
        return $this;
    }

    public function stripAll()
    {
        $this->string = preg_replace('/(?<!\$)((?:\$\$)*)\$[^$0-9a-fhlp\[\]]/iu', '$1', $this->string);
        return $this->stripEscapeCharacters()->stripLinks()->stripColors();
    }

    public function stripColors()
    {
        $this->string = preg_replace('/(?<!\$)((?:\$\$)*)\$(?:[0-9a-f][^\$]{0,2})/iu', '$1', $this->string);
        return $this;
    }

    public function stripLinks()
    {
        return $this->doStripLinks();
    }

    public function stripEscapeCharacters()
    {
        return $this->doStripEscapedChars();
    }

    protected function doStripLinks(array $codes = array('h', 'l', 'p'))
    {
        $pattern = sprintf(
            '/(?<!\$)((?:\$\$)*)\$[%s](?:\[.*?\]|\[.*?$)?(.*?)(?:\$[%1$s]|(\$z)|$)/iu',
            implode('', $codes)
        );
        $this->string = preg_replace($pattern, '$1$2$3', $this->string);
        return $this;
    }

    protected function doStripEscapedChars(array $codes = array('$', '[', ']'))
    {
        $pattern = sprintf('/\$([%s])/iu', addcslashes(implode('', $codes), '$[]'));
        $this->string = preg_replace($pattern, '$1', $this->string);
        return $this;
    }
}